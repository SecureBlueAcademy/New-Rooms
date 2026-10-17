<?php
// windows-os-hardening.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'windows-os-hardening',
    'title'           => 'Windows OS Hardening',
    'description'     => 'Learn to systematically harden Windows Server and Windows 10/11 endpoints against common attack techniques.',
    'icon'            => 'fas fa-shield-halved',
    'banner'          => '../../assets/banner-windows.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic Windows administration knowledge', 'Basic Active Directory concepts'],
    'learning_objectives' => [
        'Explain why default Windows configurations increase attack surface',
        'Configure Windows Defender and Attack Surface Reduction rules',
        'Explain the purpose of application control with AppLocker and WDAC',
        'Describe how PowerShell Constrained Language Mode limits post exploitation activity',
        'Explain how Credential Guard and LSA Protection defend against credential theft',
        'Describe how Group Policy enforces hardening at scale across a domain',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/windows-os-hardening-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Reducing the Attack Surface'],
    ['id' => 'task3', 'title' => 'Controlling What Can Run'],
    ['id' => 'task4', 'title' => 'Locking Down PowerShell'],
    ['id' => 'task5', 'title' => 'Protecting Credentials in Memory'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'windows_os_hardening_progress',
    'instagram_takeaways'  => [
        '✓ Reducing Windows attack surface with ASR rules and legacy protocol removal',
        '✓ Application control with AppLocker and WDAC',
        '✓ PowerShell Constrained Language Mode',
        '✓ Credential Guard and LSA Protection',
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
        ['id' => 'q1', 'text' => 'What legacy SMB protocol version is commonly disabled to reduce attack surface?'],
        ['id' => 'q2', 'text' => 'What is the acronym for the Microsoft Defender feature that blocks specific attack techniques, such as Office apps spawning child processes?'],
        ['id' => 'q3', 'text' => 'What term describes the total number of possible entry points an attacker could exploit on a system?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What security model allows only pre-approved applications to run and denies everything else by default?'],
        ['id' => 'q5', 'text' => 'What is Microsoft\'s modern, kernel-level application control feature that is now recommended over AppLocker?'],
        ['id' => 'q6', 'text' => 'What mode lets administrators test an application control policy without actually blocking applications?'],
    ],
    'task4' => [
        ['id' => 'q7', 'text' => 'What PowerShell mode restricts COM objects, .NET types, and arbitrary API calls to limit post exploitation activity?'],
        ['id' => 'q8', 'text' => 'What is the default, fully permissive PowerShell mode called?'],
    ],
    'task5' => [
        ['id' => 'q9',  'text' => 'What Windows process stores credentials in memory and is a common target for credential theft?'],
        ['id' => 'q10', 'text' => 'What virtualization based security feature isolates credentials in a protected memory region?'],
    ],
    'task6' => [
        ['id' => 'q11', 'text' => 'Enter the flag you discovered in the Hardening Console.'],
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
    <p>Every Windows Server and Windows 10/11 endpoint ships with far more running than most organizations actually need. Legacy protocols stay enabled, security features sit in their default weakest state, and any signed or unsigned application is free to run. Attackers rarely need to invent anything clever when this many doors are left open, they simply walk through the ones that were never closed.</p>

    <p>This room walks through the core categories of Windows hardening: shrinking the attack surface, controlling which applications can run, restricting PowerShell after a breach occurs, and protecting credentials stored in memory. You will also see how Group Policy lets every one of these controls be enforced consistently across an entire Active Directory domain. A hands-on practical lets you apply these controls directly to a simulated endpoint.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain why default Windows configurations increase attack surface.</li>
        <li>Configure Windows Defender and Attack Surface Reduction rules.</li>
        <li>Explain the purpose of application control with AppLocker and WDAC.</li>
        <li>Describe how PowerShell Constrained Language Mode limits post exploitation activity.</li>
        <li>Explain how Credential Guard and LSA Protection defend against credential theft.</li>
        <li>Describe how Group Policy enforces hardening at scale across a domain.</li>
    </ul>
</div>
HTML;

// TASK 2: Reducing the Attack Surface
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Shrinking the Attack Surface</h2>

    <p>The <strong>attack surface</strong> of a system is the sum of every entry point an attacker could use against it: running services, enabled features, open protocols, and installed roles. A default Windows install activates far more of these than most environments require, and every unused one is a door nobody is watching.</p>

    <p>Legacy protocols are one of the clearest examples. SMBv1 is an old file sharing protocol that modern Windows systems still support for backward compatibility, even though it has known, severe vulnerabilities. Worms such as WannaCry and NotPetya spread rapidly across networks specifically because SMBv1 remained enabled on so many machines. Disabling it removes an entire class of attack with a single setting.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Test Before You Disable</h4>
        <p>Disabling SMBv1 or other legacy protocols can break older applications and devices that still depend on them. Always test in a non production environment before rolling changes out fleet wide.</p>
    </div>

    <p>Windows Defender's <strong>Attack Surface Reduction</strong> (ASR) rules go a step further. Instead of removing a protocol, they block specific behaviors that malware relies on, even if the underlying feature stays enabled. This lets you close off attack techniques without disrupting normal functionality.</p>

    <h3>Common ASR Rules</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>ASR Rule Name</th>
                <th>What It Blocks</th>
                <th>Real World Technique Stopped</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Block Office apps from creating child processes</td>
                <td>Word, Excel, or Outlook launching another program</td>
                <td>Malicious macro spawning PowerShell or cmd</td>
            </tr>
            <tr>
                <td>Block credential stealing from LSASS</td>
                <td>Unauthorized processes reading LSASS memory</td>
                <td>In memory credential dumping</td>
            </tr>
            <tr>
                <td>Block executable content from email and webmail</td>
                <td>Executables launched directly from a mail client</td>
                <td>Malicious email attachment execution</td>
            </tr>
            <tr>
                <td>Block Win32 API calls from Office macros</td>
                <td>Macros calling low level system APIs</td>
                <td>Macro based payload injection</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: attack surface before and after
         Teaching purpose: show the learner that attack surface covers every exposed
         service and feature on a system, which they would otherwise misunderstand
         as being only about open network ports. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Unhardened server compared to hardened server">
            <!-- Unhardened server -->
            <rect x="20" y="20" width="330" height="180" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="185" y="45" text-anchor="middle" font-size="15" font-weight="600" fill="var(--text-primary)">Unhardened Server</text>
            <text x="45" y="75" font-size="12" fill="var(--text-secondary)">• SMBv1 enabled</text>
            <text x="45" y="98" font-size="12" fill="var(--text-secondary)">• Defender in passive mode</text>
            <text x="45" y="121" font-size="12" fill="var(--text-secondary)">• No ASR rules active</text>
            <text x="45" y="144" font-size="12" fill="var(--text-secondary)">• Unused roles installed</text>
            <text x="45" y="167" font-size="12" fill="var(--text-secondary)">• Any application can run</text>

            <!-- Arrow -->
            <line x1="360" y1="110" x2="400" y2="110" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>

            <!-- Hardened server -->
            <rect x="410" y="20" width="330" height="180" rx="10" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <text x="575" y="45" text-anchor="middle" font-size="15" font-weight="600" fill="var(--text-primary)">Hardened Server</text>
            <text x="435" y="75" font-size="12" fill="var(--text-secondary)">• SMBv1 removed</text>
            <text x="435" y="98" font-size="12" fill="var(--text-secondary)">• Defender real time protection on</text>
            <text x="435" y="121" font-size="12" fill="var(--text-secondary)">• Key ASR rules enforced</text>
            <text x="435" y="144" font-size="12" fill="var(--text-secondary)">• Unused roles removed</text>
            <text x="435" y="167" font-size="12" fill="var(--text-secondary)">• Only approved applications run</text>
        </svg>
    </div>

    <p>Reducing the attack surface does not eliminate risk entirely, but it removes the easy, automated paths that most attacks and worms rely on to spread.</p>
</div>
HTML;

// TASK 3: Controlling What Can Run
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Controlling What Can Run</h2>

    <p>Even with a reduced attack surface, an endpoint is still at risk if any application, signed or not, is free to execute. Application control flips this default. Instead of trying to block every known bad file, it only allows applications that have been explicitly approved, and denies everything else.</p>

    <p>This is the difference between <strong>blocklisting</strong> and <strong>allowlisting</strong>. A blocklist tries to keep a list of everything bad and stop it, which is a losing race against new malware. An allowlist only needs a list of what is known good, and anything not on it simply does not run.</p>

    <!-- SVG: blocklist vs allowlist
         Teaching purpose: show the learner that allowlisting defaults to deny while
         blocklisting defaults to allow, which they would otherwise misunderstand as
         two interchangeable approaches to the same problem. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Blocklisting compared to allowlisting">
            <rect x="20" y="20" width="330" height="160" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="185" y="45" text-anchor="middle" font-size="15" font-weight="600" fill="var(--text-primary)">Blocklisting</text>
            <text x="185" y="68" text-anchor="middle" font-size="12" fill="var(--text-secondary)">Default: allow everything</text>
            <text x="45" y="95" font-size="12" fill="var(--text-secondary)">• Deny known bad files</text>
            <text x="45" y="118" font-size="12" fill="var(--text-secondary)">• New threats slip through</text>
            <text x="45" y="141" font-size="12" fill="var(--text-secondary)">• Constant list updates needed</text>

            <rect x="410" y="20" width="330" height="160" rx="10" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <text x="575" y="45" text-anchor="middle" font-size="15" font-weight="600" fill="var(--text-primary)">Allowlisting</text>
            <text x="575" y="68" text-anchor="middle" font-size="12" fill="var(--text-secondary)">Default: deny everything</text>
            <text x="435" y="95" font-size="12" fill="var(--text-secondary)">• Allow only approved files</text>
            <text x="435" y="118" font-size="12" fill="var(--text-secondary)">• Unknown files never run</text>
            <text x="435" y="141" font-size="12" fill="var(--text-secondary)">• Approvals managed centrally</text>
        </svg>
    </div>

    <p>Windows offers two main tools for this: <strong>AppLocker</strong>, which runs in user mode and applies rules based on file path, publisher, or hash, and <strong>WDAC</strong> (Windows Defender Application Control), which enforces policy at the kernel level and is significantly harder for malware to bypass.</p>

    <h3>AppLocker vs WDAC</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Feature</th>
                <th>AppLocker</th>
                <th>WDAC</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Enforcement level</td>
                <td>User mode</td>
                <td>Kernel mode</td>
            </tr>
            <tr>
                <td>Bypass difficulty</td>
                <td>Easier to bypass</td>
                <td>Much harder to bypass</td>
            </tr>
            <tr>
                <td>Typical use case</td>
                <td>Legacy environments, per user rules</td>
                <td>Modern baseline, device wide policy</td>
            </tr>
        </tbody>
    </table>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>WDAC is Microsoft's recommended modern approach. Most new hardening baselines favor WDAC over AppLocker wherever it is supported.</p>
    </div>

    <p>Both tools can run in <strong>audit mode</strong> before enforcement, logging what would have been blocked without actually stopping it. This lets administrators validate a policy against real usage before turning enforcement on.</p>
</div>
HTML;

// TASK 4: Locking Down PowerShell
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Locking Down PowerShell</h2>

    <p>PowerShell is a powerful administrative tool, which is exactly why attackers rely on it so heavily once they gain a foothold on a system. By default, PowerShell runs in <strong>Full Language Mode</strong>, giving a script complete access to .NET classes, COM objects, and the Windows API. That is the same access an administrator has, and the same access a post exploitation toolkit would want.</p>

    <p><strong>Constrained Language Mode</strong> changes this. It still allows core scripting and administration, but blocks the low level building blocks that offensive frameworks depend on. It is the difference between handing someone a calculator and handing them a full programming environment. Both let them do useful work, but only one lets them build anything they want.</p>

    <h3>Full Language Mode vs Constrained Language Mode</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Capability</th>
                <th>Full Language Mode</th>
                <th>Constrained Language Mode</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Run standard cmdlets</td>
                <td>Allowed</td>
                <td>Allowed</td>
            </tr>
            <tr>
                <td>Call arbitrary .NET methods</td>
                <td>Allowed</td>
                <td>Blocked</td>
            </tr>
            <tr>
                <td>Create COM objects</td>
                <td>Allowed</td>
                <td>Blocked</td>
            </tr>
            <tr>
                <td>Invoke raw Windows API calls</td>
                <td>Allowed</td>
                <td>Blocked</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Automatic Enforcement</h4>
        <p>When WDAC is running in enforcement mode, PowerShell automatically drops into Constrained Language Mode for any script that is not explicitly trusted by the policy. This means application control and PowerShell hardening reinforce each other.</p>
    </div>

    <p>If an attacker manages to run a post exploitation script on a system in Constrained Language Mode, most of what the script relies on simply fails. The attacker still has a shell, but far less they can do with it.</p>
</div>
HTML;

// TASK 5: Protecting Credentials in Memory
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Protecting Credentials in Memory</h2>

    <p>Whenever a user logs into Windows, their credentials are handled by the <strong>Local Security Authority Subsystem Service</strong>, or LSASS. This process holds authentication material in memory so the system can validate the user without asking them to re-enter a password constantly. That convenience also makes LSASS a high value target, since reading its memory can expose credentials for every account that has recently logged in.</p>

    <p><strong>Credential Guard</strong> defends against this using virtualization based security. Instead of storing sensitive credential data inside the normal operating system, it isolates that data inside a separate, protected memory region that even a fully compromised OS cannot directly read. It is like locking the vault inside a building. An attacker who breaks into the building still cannot open the vault itself.</p>

    <!-- SVG: normal OS vs virtualization based isolation
         Teaching purpose: show the learner that Credential Guard moves credentials into
         a separate protected memory region, which they would otherwise misunderstand
         as just another LSASS configuration setting. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Normal LSASS compared to Credential Guard isolation">
            <rect x="20" y="20" width="330" height="160" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="185" y="45" text-anchor="middle" font-size="15" font-weight="600" fill="var(--text-primary)">Without Credential Guard</text>
            <rect x="60" y="70" width="250" height="80" rx="6" fill="var(--surface)" stroke="var(--text-secondary)" stroke-width="1"/>
            <text x="185" y="100" text-anchor="middle" font-size="12" fill="var(--text-secondary)">Operating System</text>
            <text x="185" y="125" text-anchor="middle" font-size="12" fill="var(--text-secondary)">LSASS + credentials</text>

            <rect x="410" y="20" width="330" height="160" rx="10" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <text x="575" y="45" text-anchor="middle" font-size="15" font-weight="600" fill="var(--text-primary)">With Credential Guard</text>
            <rect x="450" y="65" width="250" height="45" rx="6" fill="var(--surface)" stroke="var(--text-secondary)" stroke-width="1"/>
            <text x="575" y="92" text-anchor="middle" font-size="12" fill="var(--text-secondary)">Operating System</text>
            <rect x="450" y="120" width="250" height="45" rx="6" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <text x="575" y="147" text-anchor="middle" font-size="12" fill="var(--success)">Isolated credential store</text>
        </svg>
    </div>

    <p>A closely related setting is <strong>LSA Protection</strong>, sometimes called RunAsPPL. It marks the LSASS process itself as protected, so that even tools running with administrative rights cannot attach to it and read its memory directly. It does not require virtualization based security the way Credential Guard does, which makes it a useful baseline control on hardware that cannot support Credential Guard.</p>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Hardware Requirements</h4>
        <p>Credential Guard depends on UEFI, Secure Boot, and virtualization support at the hardware and firmware level. It is also incompatible with certain legacy authentication protocols, so compatibility should be verified before enabling it broadly.</p>
    </div>
</div>
HTML;

// TASK 6: Practical
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>Endpoint WIN-SRV-04 has been flagged by the security team as unhardened. None of the controls covered in this room are currently active, and its Risk Score reflects that. Your job is to work through the Hardening Console and apply each control.</p>

    <p>Enable all six hardening controls to bring the Risk Score to zero. Each toggle mirrors a concept from this room, and each one shows you exactly what it mitigates as you enable it.</p>

    <div class="practical-launch-wrapper">
        <a href="windows-os-hardening-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Hardening Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>Windows hardening is not one setting, it is a layered set of controls that each remove a specific path an attacker could otherwise use. Shrinking the attack surface closes off legacy protocols and unused features. Application control stops unapproved code from running at all. Constrained Language Mode limits what an attacker can do with PowerShell even after gaining a foothold, and Credential Guard along with LSA Protection keeps stolen access from turning into stolen credentials. None of these controls need to work alone, and applied together they are far stronger than any single setting.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Disabling unnecessary services and legacy protocols shrinks the attack surface.</li>
        <li>ASR rules block specific real world attack techniques automatically.</li>
        <li>Application control with AppLocker or WDAC enforces allowlisting instead of relying on blocklists.</li>
        <li>PowerShell Constrained Language Mode limits what attackers can do after exploitation.</li>
        <li>Credential Guard and LSA Protection isolate and protect credentials in memory.</li>
        <li>Group Policy allows all of these controls to be enforced consistently across an entire domain.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
