<?php
// risk-driven-security-engineering.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'risk-driven-security-engineering',
    'title'           => 'Risk-Driven Security Engineering',
    'description'     => 'Learn to quantify and prioritise risk to make informed engineering trade-offs using qualitative analysis, FAIR, and residual risk calculation.',
    'icon'            => 'fas fa-chart-line',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic security concepts', 'Familiarity with common threats and controls'],
    'learning_objectives' => [
        'Differentiate qualitative and quantitative risk analysis',
        'Explain the core components of the FAIR methodology',
        'Calculate residual risk after applying security controls',
        'Translate technical risk findings into business impact language',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/risk-driven-security-engineering-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Qualitative vs Quantitative Risk'],
    ['id' => 'task3', 'title' => 'FAIR Methodology'],
    ['id' => 'task4', 'title' => 'Residual Risk Calculation'],
    ['id' => 'task5', 'title' => 'Communicating Risk to Stakeholders'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'risk_driven_security_engineering_progress',
    'instagram_takeaways'  => [
        '✓ Risk equals Likelihood multiplied by Impact',
        '✓ Qualitative analysis is fast, quantitative analysis is precise',
        '✓ FAIR breaks risk into Loss Event Frequency and Loss Magnitude',
        '✓ Residual risk is what leadership should actually decide on',
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
        ['id' => 'q1', 'text' => 'What type of risk analysis expresses risk in financial or numeric terms?'],
        ['id' => 'q2', 'text' => 'What type of risk analysis uses subjective categories such as Low, Medium, or High?'],
        ['id' => 'q3', 'text' => 'What two factors are multiplied together to produce a risk score?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What is the name of the quantitative risk framework that breaks risk into Loss Event Frequency and Loss Magnitude?'],
        ['id' => 'q5', 'text' => 'What is the annualized financial output of a FAIR analysis called?'],
    ],
    'task4' => [
        ['id' => 'q6', 'text' => 'What term describes the level of risk before any controls are applied?'],
        ['id' => 'q7', 'text' => 'What term describes the risk that remains after controls are applied?'],
    ],
    'task5' => [
        ['id' => 'q8', 'text' => 'What should a risk briefing for non-technical stakeholders lead with instead of technical severity?'],
        ['id' => 'q9', 'text' => 'What type of exposure describes potential fines for failing to meet legal requirements?'],
    ],
    'task6' => [
        ['id' => 'q10', 'text' => 'Enter the flag you discovered in the Risk Register Console.'],
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
    <p>Every organization faces more security risks than it has time or budget to fix, so security engineers must decide which risks deserve attention first and why. This decision is not guesswork, it is a discipline built on comparing likelihood, impact, and cost across every risk on the table.</p>

    <p>By the end of this room you will be able to compare qualitative and quantitative risk analysis, apply the FAIR methodology to break risk into measurable parts, calculate residual risk after controls are applied, and translate technical findings into language a business leader can act on. A hands on risk register exercise reinforces every concept along the way.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Differentiate qualitative and quantitative risk analysis.</li>
        <li>Explain the core components of the FAIR methodology.</li>
        <li>Calculate residual risk after applying security controls.</li>
        <li>Translate technical risk findings into business impact language.</li>
    </ul>
</div>
HTML;

// TASK 2: Qualitative vs Quantitative Risk Analysis
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Two Ways to Measure the Same Problem</h2>

    <p>Risk is always the product of two things: how likely an event is, and how bad it would be if it happened. Every risk analysis technique tries to estimate this Likelihood multiplied by Impact relationship, but the two main approaches do it in very different ways.</p>

    <p><strong>Qualitative analysis</strong> uses descriptive categories such as Low, Medium, and High. It is fast to perform and easy for anyone to understand, but it relies on judgment rather than hard numbers. <strong>Quantitative analysis</strong> instead assigns numeric values, often financial ones, to both likelihood and impact, producing a precise figure that can be compared directly against budget and cost.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>A doctor telling a patient they have a moderate risk of complications versus a 12 percent chance of complications is making the same tradeoff security teams face daily: speed and simplicity against precision and data.</p>
    </div>

    <h3>Comparing the Two Approaches</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Approach</th>
                <th>Speed</th>
                <th>Precision</th>
                <th>Data Required</th>
                <th>Typical Use Case</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Qualitative</strong></td>
                <td>Fast</td>
                <td>Low</td>
                <td>Minimal</td>
                <td>Early stage risk triage</td>
            </tr>
            <tr>
                <td><strong>Quantitative</strong></td>
                <td>Slower</td>
                <td>High</td>
                <td>Detailed historical and financial data</td>
                <td>Budget justification and executive reporting</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: qualitative matrix vs quantitative curve
         Teaching purpose: show the learner that both approaches measure the
         same underlying risk, just with different precision, which they would
         otherwise misunderstand as two unrelated methods. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 240" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Qualitative matrix compared to quantitative curve">
            <!-- Qualitative matrix -->
            <text x="180" y="24" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Qualitative</text>
            <g>
                <rect x="60"  y="40" width="80" height="80" fill="var(--success)" opacity="0.35" stroke="var(--border)"/>
                <rect x="140" y="40" width="80" height="80" fill="var(--warning, #ffd36a)" opacity="0.35" stroke="var(--border)"/>
                <rect x="60"  y="120" width="80" height="80" fill="var(--warning, #ffd36a)" opacity="0.35" stroke="var(--border)"/>
                <rect x="140" y="120" width="80" height="80" fill="#ff5c5c" opacity="0.35" stroke="var(--border)"/>
                <text x="100" y="85" text-anchor="middle" font-size="12" fill="var(--text-primary)">Low</text>
                <text x="180" y="85" text-anchor="middle" font-size="12" fill="var(--text-primary)">Medium</text>
                <text x="100" y="165" text-anchor="middle" font-size="12" fill="var(--text-primary)">Medium</text>
                <text x="180" y="165" text-anchor="middle" font-size="12" fill="var(--text-primary)">High</text>
            </g>
            <text x="140" y="220" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Likelihood x Impact, described in words</text>

            <!-- Divider -->
            <line x1="380" y1="20" x2="380" y2="220" stroke="var(--border)" stroke-width="1"/>

            <!-- Quantitative curve -->
            <text x="580" y="24" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Quantitative</text>
            <line x1="440" y1="180" x2="720" y2="180" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="440" y1="180" x2="440" y2="40" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <path d="M440,178 C 500,175 540,150 580,110 C 620,70 660,55 715,45" fill="none" stroke="var(--primary, #6ae3ff)" stroke-width="2.5"/>
            <text x="580" y="200" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Probability</text>
            <text x="418" y="115" text-anchor="middle" font-size="11" fill="var(--text-secondary)" transform="rotate(-90 418 115)">Loss ($)</text>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Neither approach is wrong. The right choice depends on how much data is available and how the result will be used.</p>
    </div>
</div>
HTML;

// TASK 3: FAIR Methodology
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Breaking Risk Into Measurable Parts</h2>

    <p>Saying a system has "high risk" does not tell an engineer what to fix or a leader what to fund. FAIR, short for Factor Analysis of Information Risk, solves this by decomposing risk into smaller, measurable factors instead of treating it as one vague number.</p>

    <p>At the top level, FAIR splits risk into two components: <strong>Loss Event Frequency</strong>, how often a loss event is expected to occur, and <strong>Loss Magnitude</strong>, how much each event would cost. Each of these splits further into more specific factors.</p>

    <h3>The FAIR Factors</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Factor</th>
                <th>Definition</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Threat Event Frequency</strong></td>
                <td>How often a threat actor attempts to act against an asset.</td>
            </tr>
            <tr>
                <td><strong>Vulnerability</strong></td>
                <td>The probability that an attempt actually succeeds.</td>
            </tr>
            <tr>
                <td><strong>Primary Loss</strong></td>
                <td>The direct cost of the event, such as response effort or lost productivity.</td>
            </tr>
            <tr>
                <td><strong>Secondary Loss</strong></td>
                <td>Additional cost from stakeholder reactions, such as fines or reputational damage.</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: FAIR decomposition tree
         Teaching purpose: show the learner that FAIR decomposes a vague concept
         like "risk" into measurable parts, which they would otherwise
         misunderstand as a single unexplainable number. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="FAIR risk decomposition tree">
            <rect x="290" y="10" width="120" height="45" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="350" y="37" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Risk</text>

            <line x1="350" y1="55" x2="160" y2="95" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="350" y1="55" x2="540" y2="95" stroke="var(--text-secondary)" stroke-width="1.5"/>

            <rect x="60"  y="95" width="200" height="45" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="160" y="122" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Loss Event Frequency</text>

            <rect x="440" y="95" width="200" height="45" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="540" y="122" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">Loss Magnitude</text>

            <line x1="160" y1="140" x2="90" y2="175" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="160" y1="140" x2="230" y2="175" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="540" y1="140" x2="470" y2="175" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="540" y1="140" x2="610" y2="175" stroke="var(--text-secondary)" stroke-width="1.5"/>

            <text x="90"  y="192" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Threat Event Frequency</text>
            <text x="230" y="192" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Vulnerability</text>
            <text x="470" y="192" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Primary Loss</text>
            <text x="610" y="192" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Secondary Loss</text>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Annualized Loss Expectancy</h4>
        <p>The practical output of a FAIR analysis is the Annualized Loss Expectancy, a projected dollar loss per year that leadership can weigh directly against the cost of a control.</p>
    </div>
</div>
HTML;

// TASK 4: Residual Risk Calculation
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>What Remains After You Respond</h2>

    <p><strong>Inherent risk</strong> is the level of risk that exists before any control is applied. <strong>Residual risk</strong> is what remains after a control, such as multi factor authentication or network segmentation, has been put in place.</p>

    <p>No control removes all risk. Each control has a measurable effectiveness, usually expressed as a percentage reduction, which is applied to the inherent risk score to produce the residual risk score.</p>

    <h3>Worked Examples</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Finding</th>
                <th>Inherent Risk</th>
                <th>Control Applied</th>
                <th>Control Effectiveness</th>
                <th>Residual Risk</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Exposed admin panel</td>
                <td>25 (Critical)</td>
                <td>MFA and IP allowlist</td>
                <td>80%</td>
                <td>5 (Low)</td>
            </tr>
            <tr>
                <td>Legacy file share</td>
                <td>12 (High)</td>
                <td>MFA</td>
                <td>50%</td>
                <td>6 (Medium)</td>
            </tr>
            <tr>
                <td>Outdated VPN client</td>
                <td>8 (Medium)</td>
                <td>Patch and network segmentation</td>
                <td>60%</td>
                <td>3 (Low)</td>
            </tr>
        </tbody>
    </table>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Leadership should ultimately decide on residual risk, not inherent risk. Inherent risk shows the size of the problem, residual risk shows what is actually left to accept, transfer, or reduce further.</p>
    </div>
</div>
HTML;

// TASK 5: Communicating Risk to Stakeholders
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Speaking the Language of the Business</h2>

    <p>An executive does not need to know what SQL injection is. They need to know it could expose customer data and trigger a regulatory fine. Translating a technical finding into its business consequence is what turns a report into a decision.</p>

    <p>This translation should focus on financial loss, regulatory exposure, reputational damage, and operational downtime, since these are the terms in which business decisions are actually made.</p>

    <h3>From Technical Finding to Business Impact</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Technical Finding</th>
                <th>Business Impact</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>SQL injection, CVSS 9.1</td>
                <td>Potential customer data breach with estimated regulatory fines.</td>
            </tr>
            <tr>
                <td>Expired SSL certificate</td>
                <td>Browser security warnings that erode customer trust.</td>
            </tr>
            <tr>
                <td>Unpatched VPN vulnerability</td>
                <td>Possible unauthorized network access leading to operational downtime.</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Briefing Guideline</h4>
        <p>Lead with cost and consequence, not technical mechanism, when briefing non-technical stakeholders. The mechanism can follow if they ask, but the impact comes first.</p>
    </div>
</div>
HTML;

// TASK 6: Practical (Risk Register Console)
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>You have been handed five real security findings from a recent review at a mid sized company. Each finding describes an exposure in plain terms, and your job is to classify it correctly on a risk register before it goes to leadership.</p>

    <p>Open the Risk Register Console below. For each finding, set the Likelihood and Impact sliders based on the details given, then submit the completed register once all five are classified.</p>

    <div class="practical-launch-wrapper">
        <a href="risk-driven-security-engineering-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Risk Register Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>Risk-driven security engineering is about spending limited time and budget on the risks that matter most. Qualitative analysis gives speed when a quick triage is enough, FAIR gives precision when a decision needs real numbers, and residual risk keeps the focus on what remains after controls are applied rather than the raw size of the original problem.</p>

    <p>None of this matters if the result cannot be understood by the people who approve the budget. Translating findings into business impact is what turns a technical assessment into an actual decision.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Risk equals Likelihood multiplied by Impact.</li>
        <li>Qualitative analysis is fast, quantitative analysis is precise.</li>
        <li>FAIR breaks risk into Loss Event Frequency and Loss Magnitude.</li>
        <li>Residual risk reflects what remains after controls are applied.</li>
        <li>Business stakeholders respond to impact and cost, not technical severity.</li>
    </ul>
</div>
HTML;

// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
