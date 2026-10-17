<?php
// ============================================================
// security-automation-fundamentals.php
// CYBRIXEN Room Data File
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'security-automation-fundamentals',
    'title'           => 'Security Automation Fundamentals',
    'description'     => 'Learn what to automate, how automation maturity works, how to measure ROI, and how to design safe human in the loop checkpoints.',
    'icon'            => 'fas fa-robot',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '40 minutes',
    'prerequisites'   => ['Basic SOC analyst concepts', 'Familiarity with alerts and incidents'],
    'learning_objectives' => [
        'Identify which SOC tasks are good candidates for automation',
        'Explain the stages of the automation maturity model',
        'Calculate automation ROI using analyst hours saved and MTTR',
        'Design human in the loop checkpoints for high impact actions',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/security-automation-fundamentals-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What Should You Automate?'],
    ['id' => 'task3', 'title' => 'The Automation Maturity Model'],
    ['id' => 'task4', 'title' => 'Measuring Automation ROI'],
    ['id' => 'task5', 'title' => 'Over-Automation and Human-in-the-Loop Design'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'security_automation_fundamentals_progress',
    'instagram_takeaways'  => [
        '✓ What makes a task a good automation candidate',
        '✓ The four stages of the automation maturity model',
        '✓ Measuring ROI with analyst hours saved and MTTR',
        '✓ Designing human in the loop checkpoints for high impact actions',
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
        ['id' => 'q1', 'text' => 'What acronym describes security tools that orchestrate, automate, and respond to incidents?'],
        ['id' => 'q2', 'text' => 'What is the term for a predefined set of automated response steps executed by a security tool?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What is the first stage of the automation maturity model, where every action is performed by a human?'],
        ['id' => 'q4', 'text' => 'What is the term for the maturity stage where automation acts but a human must approve first?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What metric measures the average time taken to respond to an incident?'],
        ['id' => 'q6', 'text' => 'Alongside MTTR, what resource savings are typically measured to justify automation ROI?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'What term describes requiring human approval before a high impact automated action executes?'],
        ['id' => 'q8', 'text' => 'What term describes the scope of damage an action can cause if it goes wrong?'],
    ],
    'task6' => [
        ['id' => 'q9', 'text' => 'Enter the flag you discovered in the Automation Triage Desk.'],
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
    <p>Security teams now face far more alerts than any analyst could ever review by hand, and automation has become the only realistic way to keep pace. Used well, automation clears routine noise so analysts can focus on judgement calls that actually need a human. Used poorly, it can fire off destructive actions faster than anyone can catch a mistake.</p>

    <p>By the end of this room you will be able to identify which tasks are safe to automate, understand the stages of automation maturity, calculate the ROI of an automation program in real terms, and design checkpoints that keep high impact actions under human control. A hands-on practical is included to put these ideas into practice.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Identify which SOC tasks are good candidates for automation.</li>
        <li>Explain the stages of the automation maturity model.</li>
        <li>Calculate automation ROI using analyst hours saved and MTTR.</li>
        <li>Design human in the loop checkpoints for high impact actions.</li>
    </ul>
</div>
HTML;

// TASK 2: What Should You Automate?
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Choosing the Right Tasks to Automate</h2>

    <p>Not every SOC task belongs in an automated pipeline. The best candidates share three traits: they happen often, they follow a predictable pattern, and they require little to no judgement. Tasks that are rare, ambiguous, or carry heavy consequences if wrong should stay in human hands.</p>

    <p>Think of the difference between an assembly line worker and a judge. The assembly line worker repeats the same clear steps thousands of times a day, which is exactly what automation is good at. A judge weighs context, intent, and consequence, which is exactly what automation struggles to do.</p>

    <!-- SVG: Good vs poor automation candidate comparison
         Teaching purpose: show the learner the shape of the distinction between
         good and poor automation candidates, which they would otherwise
         misunderstand as a vague feeling rather than a concrete set of traits. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 260" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Good versus poor automation candidate comparison">
            <!-- Column headers -->
            <rect x="20" y="10" width="320" height="40" rx="8" fill="var(--success)" opacity="0.15" stroke="var(--success)" stroke-width="1.5"/>
            <text x="180" y="36" text-anchor="middle" font-size="16" font-weight="600" fill="var(--text-primary)">Good Automation Candidate</text>

            <rect x="360" y="10" width="320" height="40" rx="8" fill="var(--error, #ff5c5c)" opacity="0.12" stroke="var(--error, #ff5c5c)" stroke-width="1.5"/>
            <text x="520" y="36" text-anchor="middle" font-size="16" font-weight="600" fill="var(--text-primary)">Poor Automation Candidate</text>

            <!-- Left column body -->
            <rect x="20" y="60" width="320" height="180" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="40" y="90" font-size="13" fill="var(--text-primary)">✓ High volume, repeated often</text>
            <text x="40" y="120" font-size="13" fill="var(--text-primary)">✓ Predictable, rule based pattern</text>
            <text x="40" y="150" font-size="13" fill="var(--text-primary)">✓ Low judgement required</text>
            <text x="40" y="180" font-size="13" fill="var(--text-primary)">✓ Easily reversible if wrong</text>
            <text x="40" y="210" font-size="13" fill="var(--text-secondary)">e.g. threat intel enrichment</text>

            <!-- Right column body -->
            <rect x="360" y="60" width="320" height="180" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="380" y="90" font-size="13" fill="var(--text-primary)">✗ Rare or one-off situation</text>
            <text x="380" y="120" font-size="13" fill="var(--text-primary)">✗ Requires context and nuance</text>
            <text x="380" y="150" font-size="13" fill="var(--text-primary)">✗ High judgement required</text>
            <text x="380" y="180" font-size="13" fill="var(--text-primary)">✗ Hard to reverse if wrong</text>
            <text x="380" y="210" font-size="13" fill="var(--text-secondary)">e.g. notifying customers of a breach</text>
        </svg>
    </div>

    <h3>Examples in Practice</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Task Type</th>
                <th>Volume</th>
                <th>Judgement Needed</th>
                <th>Automate?</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>IP threat intel enrichment</td>
                <td>High</td>
                <td>Low</td>
                <td>Yes</td>
            </tr>
            <tr>
                <td>Isolating a VIP executive's device</td>
                <td>Low</td>
                <td>High</td>
                <td>Human review first</td>
            </tr>
            <tr>
                <td>Deduplicating repeated low severity alerts</td>
                <td>High</td>
                <td>Low</td>
                <td>Yes</td>
            </tr>
            <tr>
                <td>Notifying customers of a data breach</td>
                <td>Low</td>
                <td>High</td>
                <td>No, keep manual</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Watch for Exceptions</h4>
        <p>A process can look automatable on the surface but hide frequent exceptions underneath. If a "simple" workflow needs constant special case handling, automating it too early usually just moves the mistakes somewhere less visible.</p>
    </div>
</div>
HTML;

// TASK 3: The Automation Maturity Model
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>A Staged Path, Not a Switch</h2>

    <p>Automation maturity is not a single decision to flip a task from manual to automated. Most security teams move through it in stages, building trust in the automation before removing the human step entirely.</p>

    <p>This is similar to learning to drive. A new driver starts with an instructor controlling almost everything, then gradually takes over individual actions, and only drives solo once every step has been proven safe. Automation maturity works the same way.</p>

    <!-- SVG: Automation maturity ladder
         Teaching purpose: show the learner that maturity is a sequential
         progression through four stages, which they would otherwise
         misunderstand as a binary automated versus not automated choice. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 160" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Automation maturity model with four stages">
            <rect x="10"  y="40" width="170" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="200" y="40" width="170" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="390" y="40" width="170" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="580" y="40" width="170" height="80" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>

            <line x1="180" y1="80" x2="196" y2="80" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="370" y1="80" x2="386" y2="80" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="560" y1="80" x2="576" y2="80" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>

            <text x="95"  y="72" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Manual</text>
            <text x="95"  y="92" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Human does everything</text>

            <text x="285" y="72" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Assisted</text>
            <text x="285" y="92" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Tool suggests, human acts</text>

            <text x="475" y="72" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Semi-Automated</text>
            <text x="475" y="92" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Tool acts, human approves</text>

            <text x="665" y="72" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Fully Automated</text>
            <text x="665" y="92" text-anchor="middle" font-size="10" fill="var(--text-secondary)">No human step required</text>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Even the most mature SOCs usually keep a manual tier for rare, high stakes situations. Reaching full automation everywhere is not the goal. Reaching the right stage for each task is.</p>
    </div>
</div>
HTML;

// TASK 4: Measuring Automation ROI
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Proving the Value of Automation</h2>

    <p>Automation is only worth building if it produces a measurable improvement. The two most common metrics are analyst hours saved and Mean Time to Respond, usually shortened to MTTR.</p>

    <p>This is similar to deciding whether a household appliance is worth buying. If a dishwasher saves you thirty minutes a day, that time savings is easy to calculate and easy to justify against the cost of the appliance. Automation ROI works the same way, just measured in analyst minutes instead of dish washing minutes.</p>

    <h3>A Worked Example</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Metric</th>
                <th>Before Automation</th>
                <th>After Automation</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Alerts handled per month</td>
                <td>3,000</td>
                <td>3,000</td>
            </tr>
            <tr>
                <td>Analyst minutes per alert</td>
                <td>8 minutes</td>
                <td>2 minutes</td>
            </tr>
            <tr>
                <td>Total analyst hours per month</td>
                <td>400 hours</td>
                <td>100 hours</td>
            </tr>
            <tr>
                <td>Mean Time to Respond</td>
                <td>45 minutes</td>
                <td>12 minutes</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> What MTTR Actually Measures</h4>
        <p>MTTR is the average time between an alert being generated and the response being completed. A lower MTTR means threats are contained faster, which directly reduces the damage an attacker can do.</p>
    </div>
</div>
HTML;

// TASK 5: Over-Automation and Human-in-the-Loop Design
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>When Automation Goes Too Far</h2>

    <p>Automating a high volume, low risk task is safe because a mistake is small and easy to undo. Automating a high impact action without a checkpoint is a different problem entirely, because a single wrong trigger can cause real business disruption before anyone notices.</p>

    <p>Consider a fire sprinkler system that triggers on burnt toast. It works exactly as designed, reacting instantly to smoke, but the outcome is a soaked kitchen over nothing dangerous. Fully automated security actions can fail the same way if they are not scoped carefully.</p>

    <!-- SVG: Human in the loop checkpoint flow
         Teaching purpose: show the learner exactly where a human approval
         step sits in an automated response flow, which they would otherwise
         misunderstand as an extra delay rather than a safety checkpoint. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Human in the loop checkpoint flow">
            <rect x="10" y="70" width="140" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="80" y="105" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Alert Fires</text>

            <polygon points="230,60 320,100 230,140 140,100" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="230" y="95" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">High</text>
            <text x="230" y="110" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">impact?</text>

            <rect x="380" y="10" width="160" height="60" rx="8" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <text x="460" y="35" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Human Approval</text>
            <text x="460" y="53" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Checkpoint</text>

            <rect x="380" y="130" width="160" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="460" y="155" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Execute Directly</text>
            <text x="460" y="173" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Low impact action</text>

            <rect x="580" y="70" width="110" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="635" y="105" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Action Runs</text>

            <line x1="150" y1="100" x2="228" y2="100" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="285" y1="75" x2="378" y2="42" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="285" y1="125" x2="378" y2="158" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="540" y1="42" x2="600" y2="72" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="540" y1="158" x2="600" y2="128" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>

            <text x="330" y="55" font-size="10" fill="var(--text-secondary)">Yes</text>
            <text x="330" y="150" font-size="10" fill="var(--text-secondary)">No</text>

            <defs>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> A Real World Style Incident</h4>
        <p>A SOC once configured automatic host isolation for any alert above a certain severity score. A misconfigured scanner triggered thousands of false positives overnight, and the automation isolated dozens of production servers before anyone woke up. A single approval checkpoint on host isolation would have prevented the outage.</p>
    </div>
</div>
HTML;

// TASK 6: Practical
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>You are acting as a SOC automation architect. A queue of real world security tasks needs to be sorted into the correct automation tier: fully automated, automated with human approval, or kept fully manual.</p>

    <p>Review each task carefully, consider its volume, its need for judgement, and the impact if it goes wrong, then place it in the correct bin. Sort all tasks correctly to reveal the flag.</p>

    <div class="practical-launch-wrapper">
        <a href="security-automation-fundamentals-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Automation Triage Desk</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You now understand how to approach security automation responsibly. Good automation targets tasks that are high volume, low judgement, and easy to reverse, while it follows a staged maturity path rather than an all or nothing switch. Its value should always be measured in concrete terms, such as analyst hours saved and improved MTTR.</p>

    <p>Just as importantly, high impact actions deserve a human checkpoint before they execute. Mastering that balance between speed and safety is what separates a mature automation program from one that creates its own incidents.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Automate tasks that are high volume, low judgement, and easily reversible.</li>
        <li>Automation maturity progresses through stages, it is not a binary switch.</li>
        <li>ROI should be measured using analyst hours saved and MTTR.</li>
        <li>High impact actions need human in the loop checkpoints before they execute.</li>
        <li>Over-automating response actions creates its own category of risk.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
