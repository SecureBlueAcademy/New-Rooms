<?php
// ============================================================
// what-is-penetration-testing.php
// CYBRIXEN Room Data File
// Topic: What is Penetration Testing?
// Type: Standard Room (Type A)
// Difficulty: Beginner | Estimated Time: 45 minutes
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'what-is-penetration-testing',
    'title'           => 'What is Penetration Testing?',
    'description'     => 'Understand what penetration testing is, how it differs from vulnerability scanning and red teaming, and why organisations hire ethical hackers to find weaknesses before real attackers do.',
    'icon'            => 'fas fa-user-secret',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Beginner',
    'estimated_time'  => '45 minutes',
    'prerequisites'   => ['Basic computer knowledge', 'Basic understanding of what cybersecurity is'],
    'learning_objectives' => [
        'Define penetration testing and explain its core purpose',
        'Distinguish penetration testing from vulnerability scanning and red teaming',
        'Describe the five phases of a standard penetration test',
        'Identify the three legal engagement types: black box, grey box, and white box',
        'Explain the attacker mindset and why it is central to effective pentesting',
        'Understand why organisations commission penetration tests and what they gain from them',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/what-is-penetration-testing-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What is a Pentest?'],
    ['id' => 'task3', 'title' => 'Pentest vs Scanning vs Red Team'],
    ['id' => 'task4', 'title' => 'The Five Phases'],
    ['id' => 'task5', 'title' => 'Engagement Types'],
    ['id' => 'task6', 'title' => 'The Attacker Mindset'],
    ['id' => 'task7', 'title' => 'Practical'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'what_is_penetration_testing_progress',
    'instagram_takeaways'  => [
        '✓ Penetration testing: finding weaknesses before attackers do',
        '✓ Pentest vs vulnerability scanning vs red teaming',
        '✓ The five phases: Recon, Scanning, Exploitation, Post-Exploitation, Reporting',
        '✓ Black box, grey box, and white box engagement types',
        '✓ The attacker mindset: thinking like the threat',
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
        ['id' => 'q1', 'text' => 'What is the short term used for an authorised simulated attack on a system to find vulnerabilities?'],
        ['id' => 'q2', 'text' => 'What document gives a penetration tester legal permission to test a target system?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What type of security assessment runs automated tools to detect known vulnerabilities without attempting to exploit them?'],
        ['id' => 'q4', 'text' => 'What term describes a long-duration, covert simulation of a real advanced threat actor, going beyond just finding vulnerabilities?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What is the first phase of a penetration test, where the tester gathers information about the target?'],
        ['id' => 'q6', 'text' => 'In which phase does the tester document all findings, evidence, and remediation guidance for the client?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'In which engagement type does the tester receive no prior knowledge about the target system?'],
        ['id' => 'q8', 'text' => 'Which engagement type provides the tester with full system knowledge, such as source code and architecture diagrams?'],
    ],
    'task6' => [
        ['id' => 'q9', 'text' => 'What two-word term describes the process of thinking and acting from the perspective of a malicious attacker?'],
        ['id' => 'q10', 'text' => 'What is the term for the total set of entry points an attacker could use to compromise a system?'],
    ],
    'task7' => [
        ['id' => 'q11', 'text' => 'Enter the flag you discovered in the Scope Analyser.'],
    ],
    'task8' => [
        ['id' => 'q12', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Every organisation that connects systems to the internet is a potential target. The question is not whether vulnerabilities exist, but whether anyone finds them first. Penetration testing is the discipline of finding those weaknesses intentionally, by thinking and acting like an attacker, before a real one gets the chance. It is one of the most hands-on, consequential skills in all of cybersecurity.</p>

    <p>This room explains exactly what a penetration test is, how it differs from other types of security assessments, and why organisations pay professionals to attack their own systems. By the end, you will understand the full lifecycle of a pentest, the legal frameworks that make it legitimate, and the attacker mindset that makes it effective. A hands-on practical is included to put these concepts to work.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Define penetration testing and explain its core purpose.</li>
        <li>Distinguish penetration testing from vulnerability scanning and red teaming.</li>
        <li>Describe the five phases of a standard penetration test.</li>
        <li>Identify the three legal engagement types: black box, grey box, and white box.</li>
        <li>Explain the attacker mindset and why it is central to effective pentesting.</li>
        <li>Understand why organisations commission penetration tests and what they gain from them.</li>
    </ul>
</div>
HTML;

// TASK 2: What is a Pentest?
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Simulating the Attacker</h2>

    <p>A <strong>penetration test</strong> (pentest) is an authorised, simulated cyberattack performed against a system, network, or application to identify vulnerabilities that a real attacker could exploit. The key word is authorised. Without written permission from the system owner, the same actions that constitute a pentest would constitute a crime.</p>

    <p>Think of it like a bank hiring a professional locksmith to try every door and window before opening. The locksmith is not trying to rob the bank; they are proving which entry points are weak so the bank can fix them before someone with bad intentions finds them first.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Authorisation is Everything</h4>
        <p>Every penetration test must begin with a signed agreement that defines exactly what systems may be tested, when, and by whom. This document is called the <strong>scope of engagement</strong> or Rules of Engagement (RoE). Testing anything outside that scope, even accidentally, can have serious legal consequences.</p>
    </div>

    <h3>What Organisations Gain from a Pentest</h3>
    <p>Organisations hire penetration testers for several interconnected reasons. Security teams are often too close to their own systems to spot blind spots. A skilled external tester brings fresh eyes and adversarial thinking. The output of a pentest is typically a detailed report listing discovered vulnerabilities, evidence of successful exploitation, and prioritised remediation guidance.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>What Organisations Want to Know</th>
                <th>What a Pentest Answers</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Can an outsider break in?</td>
                <td>Tests external-facing systems and entry points</td>
            </tr>
            <tr>
                <td>How far could an attacker go if they got in?</td>
                <td>Tests lateral movement, privilege escalation, and data access</td>
            </tr>
            <tr>
                <td>Are our defences actually working?</td>
                <td>Tests detection, alerting, and incident response capability</td>
            </tr>
            <tr>
                <td>Are we compliant with security standards?</td>
                <td>Provides audit evidence for regulations like PCI DSS, ISO 27001</td>
            </tr>
        </tbody>
    </table>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>A penetration test is not just about finding vulnerabilities. It is about proving exploitability and business impact, then translating that into action the organisation can take.</p>
    </div>
</div>
HTML;

// TASK 3: Pentest vs Scanning vs Red Team
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Not All Security Assessments Are Equal</h2>

    <p>Penetration testing is often confused with two related disciplines: vulnerability scanning and red teaming. All three involve probing systems for weaknesses, but they differ enormously in depth, duration, objectives, and the level of human skill involved. Choosing the wrong type of assessment leaves critical gaps.</p>

    <!-- SVG: Teaching purpose: show the learner that these three assessments sit on a spectrum
         of depth and realism, which they would otherwise misunderstand as three different names
         for the same thing. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 130" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Assessment depth spectrum from vulnerability scanning to red teaming">
            <!-- Spectrum bar -->
            <defs>
                <linearGradient id="spectrumGrad" x1="0" y1="0" x2="1" y2="0">
                    <stop offset="0%" stop-color="#2a6496"/>
                    <stop offset="50%" stop-color="#1a7a5e"/>
                    <stop offset="100%" stop-color="#7a1a4a"/>
                </linearGradient>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <!-- Arrow showing spectrum direction -->
            <line x1="30" y1="60" x2="730" y2="60" stroke="var(--border)" stroke-width="2" marker-end="url(#arr2)"/>
            <!-- Marker dots -->
            <circle cx="120" cy="60" r="10" fill="#2a6496"/>
            <circle cx="385" cy="60" r="10" fill="#1a7a5e"/>
            <circle cx="650" cy="60" r="10" fill="#7a1a4a"/>
            <!-- Labels above -->
            <text x="120" y="38" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Vulnerability Scan</text>
            <text x="385" y="38" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Penetration Test</text>
            <text x="650" y="38" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Red Team Exercise</text>
            <!-- Labels below -->
            <text x="120" y="85" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Automated</text>
            <text x="385" y="85" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Human-led</text>
            <text x="650" y="85" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Adversarial simulation</text>
            <!-- Spectrum label -->
            <text x="380" y="115" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Increasing depth, realism, and cost</text>
        </svg>
    </div>

    <h3>Comparing the Three Approaches</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Aspect</th>
                <th>Vulnerability Scanning</th>
                <th>Penetration Testing</th>
                <th>Red Team Exercise</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Who performs it</strong></td>
                <td>Automated tool (minimal human involvement)</td>
                <td>Skilled human tester</td>
                <td>Highly skilled adversary simulation team</td>
            </tr>
            <tr>
                <td><strong>Goal</strong></td>
                <td>List known vulnerabilities</td>
                <td>Prove exploitability and impact</td>
                <td>Test detection, response, and resilience</td>
            </tr>
            <tr>
                <td><strong>Exploitation</strong></td>
                <td>None. Detection only.</td>
                <td>Yes, within defined scope</td>
                <td>Yes, with full attacker tactics and evasion</td>
            </tr>
            <tr>
                <td><strong>Typical duration</strong></td>
                <td>Hours to one day</td>
                <td>Days to two weeks</td>
                <td>Weeks to months</td>
            </tr>
            <tr>
                <td><strong>Awareness</strong></td>
                <td>Security team is always aware</td>
                <td>Security team is usually aware</td>
                <td>Security team often unaware (tests detection)</td>
            </tr>
            <tr>
                <td><strong>Output</strong></td>
                <td>Vulnerability list with severity scores</td>
                <td>Detailed report with exploitation evidence</td>
                <td>Full attack narrative and detection gap analysis</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Common Misconception</h4>
        <p>Vulnerability scanning tells you a door might be unlocked. Penetration testing proves the door is unlocked by walking through it. These are not interchangeable. An organisation that only scans may still be wide open to a determined attacker.</p>
    </div>
</div>
HTML;

// TASK 4: The Five Phases
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>How a Penetration Test Actually Works</h2>

    <p>A penetration test is not a chaotic process of throwing attacks at a system and hoping something sticks. It follows a structured methodology, typically broken into five phases. Understanding these phases is essential both for performing tests and for understanding what you are paying for when you commission one.</p>

    <!-- SVG: Teaching purpose: show the learner that a pentest is a deliberate sequential process,
         which they would otherwise misunderstand as a single undifferentiated "hacking" activity. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 100" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Five phases of a penetration test">
            <defs>
                <marker id="arr3" markerWidth="7" markerHeight="7" refX="5" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L7,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <!-- Phase boxes -->
            <rect x="5"   y="20" width="120" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="158" y="20" width="120" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="311" y="20" width="120" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="464" y="20" width="120" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="617" y="20" width="138" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <!-- Arrows -->
            <line x1="125" y1="50" x2="154" y2="50" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="278" y1="50" x2="307" y2="50" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="431" y1="50" x2="460" y2="50" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="584" y1="50" x2="613" y2="50" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <!-- Phase labels -->
            <text x="65"  y="46" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">1. Recon</text>
            <text x="65"  y="64" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Gather intel</text>
            <text x="218" y="46" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">2. Scanning</text>
            <text x="218" y="64" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Map the surface</text>
            <text x="371" y="46" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">3. Exploitation</text>
            <text x="371" y="64" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Prove the flaw</text>
            <text x="524" y="46" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">4. Post-Exploit</text>
            <text x="524" y="64" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Assess impact</text>
            <text x="686" y="46" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">5. Reporting</text>
            <text x="686" y="64" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Deliver findings</text>
        </svg>
    </div>

    <h3>Phase 1: Reconnaissance</h3>
    <p>Before a single packet is sent, a skilled tester learns as much as possible about the target. This is called <strong>reconnaissance</strong>. It involves gathering publicly available information: domain names, IP address ranges, employee names on LinkedIn, technology stacks from job postings, and more. Passive reconnaissance never touches the target's systems. Active reconnaissance begins interacting with them directly.</p>

    <h3>Phase 2: Scanning and Enumeration</h3>
    <p>With a target profile in hand, the tester maps the attack surface in detail. Port scanners identify open network services. Vulnerability scanners flag known weaknesses. Enumeration tools extract usernames, file shares, and configuration details. This phase builds a precise picture of what is running and how it might be attacked.</p>

    <h3>Phase 3: Exploitation</h3>
    <p>This is where the pentest diverges from a vulnerability scan. The tester actively attempts to exploit discovered weaknesses, proving that they can be used to gain unauthorised access or cause damage. Successful exploitation demonstrates real business risk, not just theoretical risk. Every exploitation attempt is logged with evidence.</p>

    <h3>Phase 4: Post-Exploitation</h3>
    <p>Gaining initial access is often just the beginning. Post-exploitation asks: how far could an attacker go from here? The tester attempts lateral movement across the network, privilege escalation to gain administrator access, and data exfiltration to show what an attacker could steal. This phase reveals the true blast radius of a compromise.</p>

    <h3>Phase 5: Reporting</h3>
    <p>Every finding must be documented and communicated. The final report typically includes an executive summary for non-technical leadership, a technical section detailing every vulnerability with reproduction steps and evidence, and a prioritised remediation plan. A pentest without a high-quality report is largely wasted effort.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Remediation Testing</h4>
        <p>Many engagements include a follow-up phase after the client fixes the reported issues. The tester re-tests the specific vulnerabilities to confirm they have been resolved correctly. This is called a remediation check or retest.</p>
    </div>
</div>
HTML;

// TASK 5: Engagement Types
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>What Does the Tester Know Going In?</h2>

    <p>Before a penetration test begins, one of the most important decisions is how much information the tester receives about the target. This shapes the entire engagement: the techniques used, the time required, and the realistic threat scenario being simulated. There are three standard engagement types.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Engagement Type</th>
                <th>Prior Knowledge Given</th>
                <th>What It Simulates</th>
                <th>Best Used For</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Black Box</strong></td>
                <td>None. The tester starts with only a target name or IP range.</td>
                <td>An external attacker with no inside information</td>
                <td>Testing what the internet-facing perimeter looks like to an outsider</td>
            </tr>
            <tr>
                <td><strong>Grey Box</strong></td>
                <td>Partial. The tester receives some information, such as user credentials or network diagrams.</td>
                <td>A partially informed attacker, such as a disgruntled employee or a contractor</td>
                <td>Efficient testing of specific systems or insider threat scenarios</td>
            </tr>
            <tr>
                <td><strong>White Box</strong></td>
                <td>Full. Source code, architecture documents, credentials, and full system knowledge.</td>
                <td>A deeply knowledgeable insider or a thorough code review scenario</td>
                <td>Maximum coverage and depth, compliance-driven testing</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Which Type is Best?</h4>
        <p>There is no universally best type. Black box tests are the most realistic but the least efficient. White box tests find the most vulnerabilities but may not reflect what a real-world attacker could discover. Many organisations run a combination over time. Grey box testing is the most common choice because it balances realism with time efficiency.</p>
    </div>

    <h3>Scope: Defining the Boundaries</h3>
    <p>Regardless of the engagement type, every pentest operates within a defined <strong>scope</strong>. The scope document specifies exactly which IP addresses, domains, applications, and systems are in scope for testing. It also defines what is explicitly out of scope, the testing window (dates and times), and any rules around destructive testing. Staying within scope is a legal and professional requirement, not a suggestion.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Out of Scope Means Off Limits</h4>
        <p>If a tester discovers a path into a system that is not in scope, they must stop, document the finding, and report it to the client. Testing out-of-scope systems without permission, even in pursuit of a legitimate finding, crosses the legal boundary between ethical hacking and a criminal offence.</p>
    </div>
</div>
HTML;

// TASK 6: The Attacker Mindset
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Thinking Like the Threat</h2>

    <p>Technical skills are necessary for penetration testing, but they are not sufficient. What separates a good pentester from a great one is a specific way of thinking: the <strong>attacker mindset</strong>. This means approaching every system not as its designer or administrator, but as someone trying to find ways it can be made to do something it was never intended to do.</p>

    <p>A defender tends to think about what the system is supposed to do. An attacker thinks about what the system can be made to do. That mental shift changes everything. A login form is not just a way to authenticate users; it is a potential target for injection attacks, brute force, or logic flaws in the way it handles failed attempts.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> The Attacker Mindset in Practice</h4>
        <p>When a pentester looks at a web application, they ask: what happens if I send unexpected input here? What if I modify this parameter? What if I submit this form twice? What if I access this URL without being logged in? These questions lead to discoveries that automated tools miss entirely.</p>
    </div>

    <h3>Attack Surface Awareness</h3>
    <p>A core skill in the attacker mindset is understanding the concept of <strong>attack surface</strong>. The attack surface is the total set of entry points through which an attacker could attempt to interact with or compromise a system. Every open port, every web form, every API endpoint, every employee email address, and every physical access point is part of the attack surface. A pentester's job is to map it completely and then probe each element for weakness.</p>

    <h3>Why the Mindset Matters More Than the Tools</h3>
    <p>Tools are widely available. Metasploit, Nmap, Burp Suite, and hundreds of other utilities are freely downloadable. The tools themselves do not make someone a pentester. What matters is the judgment to know which tool to use, when to use it, and how to interpret the results in the context of that specific target. That judgment is an expression of the attacker mindset applied to a real situation.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Defender Thinking</th>
                <th>Attacker Thinking</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>"This field only accepts numbers, so it's safe."</td>
                <td>"What happens if I submit text, special characters, or SQL syntax?"</td>
            </tr>
            <tr>
                <td>"Users cannot see each other's files."</td>
                <td>"What if I change the file ID in the URL to another user's ID?"</td>
            </tr>
            <tr>
                <td>"The admin panel is not linked from the homepage."</td>
                <td>"Common admin paths like /admin, /dashboard, and /manage are worth trying."</td>
            </tr>
            <tr>
                <td>"We have a firewall blocking inbound connections."</td>
                <td>"Can I make the internal system reach out to me instead?"</td>
            </tr>
        </tbody>
    </table>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>The attacker mindset is not about being malicious. It is about being thorough. Every assumption a defender makes is a potential gap. A pentester's job is to find those gaps before someone with actual malicious intent does.</p>
    </div>
</div>
HTML;

// TASK 7: Practical
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You are a junior penetration tester who has just joined a firm. Before your first real engagement, your team lead asks you to work through a simulated scope review using the firm's internal Scope Analyser tool. You will be presented with a mock client engagement package and must correctly classify each element, identify what is in and out of scope, and match findings to the correct pentest phase.</p>

    <p>Read each section of the engagement package carefully. The attacker mindset and phase knowledge you have built in this room are everything you need. The flag is revealed once you have completed all three stages of the analysis.</p>

    <div class="practical-launch-wrapper">
        <a href="what-is-penetration-testing-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Scope Analyser</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 8: Conclusion
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>Penetration testing is one of the most direct ways an organisation can understand its real security posture. It is not a checkbox exercise; it is a structured, human-led process of discovering what an attacker could do, proving it with evidence, and giving the organisation the information it needs to fix the problems that matter most. The skills involved span technical knowledge, legal awareness, structured methodology, and the attacker mindset that ties it all together.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>A penetration test is an authorised simulated attack aimed at finding and proving exploitable vulnerabilities.</li>
        <li>Vulnerability scanning detects; penetration testing exploits. They are not the same thing.</li>
        <li>Red team exercises go further than pentests by simulating full adversary behaviour to test detection and response.</li>
        <li>Every pentest follows five phases: Reconnaissance, Scanning, Exploitation, Post-Exploitation, and Reporting.</li>
        <li>Engagement types (black, grey, white box) determine how much prior knowledge the tester has and what threat scenario is being simulated.</li>
        <li>The attacker mindset is the ability to question assumptions, probe unexpected paths, and think about what a system can be made to do rather than what it was designed to do.</li>
        <li>Scope defines the legal and professional boundaries of every engagement. Staying within scope is non-negotiable.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA - engine renders everything from here.
// These two lines must always be last, in this order.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
