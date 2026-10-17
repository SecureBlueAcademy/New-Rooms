<?php
// ============================================================
// wordlist-attacks.php — ROOM DATA FILE
// Topic: Wordlist Attacks & Dictionary Cracking
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'wordlist-attacks',
    'title'           => 'Wordlist Attacks & Dictionary Cracking',
    'description'     => 'Learn how attackers use wordlists and rule based mutations to crack passwords, and how tools like Hashcat and John the Ripper make it possible.',
    'icon'            => 'fas fa-key',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Beginner',
    'estimated_time'  => '40 minutes',
    'prerequisites'   => ['Basic computer knowledge'],
    'learning_objectives' => [
        'Explain what a wordlist is and where lists like RockYou come from',
        'Describe how cracking tools compare hashed guesses to a target hash',
        'Explain how rule based mutations multiply the value of a wordlist',
        'Identify when wordlist attacks succeed and how defenders reduce that risk',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/wordlist-attacks-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What Are Wordlists?'],
    ['id' => 'task3', 'title' => 'Cracking Tools Conceptually'],
    ['id' => 'task4', 'title' => 'Rules Based Mutations'],
    ['id' => 'task5', 'title' => 'Strategy and Limitations'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'wordlist_attacks_progress',
    'instagram_takeaways'  => [
        '✓ Wordlists come from real breaches, not invented word lists',
        '✓ Cracking tools hash guesses and compare, they never decrypt',
        '✓ Rule based mutations turn one wordlist into billions of guesses',
        '✓ Long unique passwords and MFA defeat wordlist attacks',
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
        ['id' => 'q1', 'text' => 'What was the name of the 2009 data breach that leaked millions of plaintext passwords, giving rise to a widely used wordlist?'],
        ['id' => 'q2', 'text' => 'What term describes an attack that tries every entry in a prebuilt list of likely passwords?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What is the term for a one way function that converts a password into a fixed length string?'],
        ['id' => 'q4', 'text' => 'What hardware component is primarily used to accelerate Hashcat\'s cracking speed?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What is the term for a predefined transformation applied to each wordlist entry to generate new guesses?'],
        ['id' => 'q6', 'text' => 'What is the name for the technique of substituting letters with similar looking numbers or symbols, such as "a" to "4"?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'What is the term for a second verification factor used alongside a password to strengthen authentication?'],
        ['id' => 'q8', 'text' => 'What is the term for random data added to a password before hashing to defeat precomputed wordlist attacks?'],
    ],
    'task6' => [
        ['id' => 'q9', 'text' => 'Enter the flag you discovered in the Password Cracker Console.'],
    ],
    'task7' => [
        ['id' => 'q10', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Most password breaches are not the result of a genius exploit. They happen because a password already exists in a list somewhere, leaked from a previous breach years earlier. Wordlist attacks exploit this simple fact by trying real, previously used passwords instead of guessing randomly.</p>

    <p>By the end of this room you will be able to explain where wordlists like RockYou come from, understand conceptually how tools such as Hashcat and John the Ripper crack passwords, and describe how rule based mutations turn a small wordlist into billions of effective guesses. A hands on lab is included to put this into practice.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain what a wordlist is and where lists like RockYou come from.</li>
        <li>Describe how cracking tools compare hashed guesses to a target hash.</li>
        <li>Explain how rule based mutations multiply the value of a wordlist.</li>
        <li>Identify when wordlist attacks succeed and how defenders reduce that risk.</li>
    </ul>
</div>
HTML;

// TASK 2: What Are Wordlists?
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Real Passwords, Recycled</h2>

    <p>A wordlist is simply a text file containing candidate passwords, one per line. What makes wordlists effective is that the entries are not invented. They are almost always real passwords collected from previous data breaches.</p>

    <p>Think of a wordlist like a giant keyring built from spare keys found at the scenes of other break ins. None of those keys were designed for your lock, but people reuse the same keys so often that trying them first is a very efficient strategy.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> The RockYou Breach</h4>
        <p>In 2009, the social platform RockYou suffered a breach that exposed over 32 million user passwords in plain text, unencrypted. The resulting list, known simply as RockYou, became one of the most widely used wordlists in security testing and remains in use today.</p>
    </div>

    <h3>Dictionary Attack vs Brute Force</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Attack Type</th>
                <th>How It Works</th>
                <th>Speed</th>
                <th>Best Against</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Dictionary attack</strong></td>
                <td>Tries entries from a prebuilt wordlist of real passwords.</td>
                <td>Fast</td>
                <td>Weak or reused passwords.</td>
            </tr>
            <tr>
                <td>Brute force</td>
                <td>Tries every possible character combination.</td>
                <td>Very slow</td>
                <td>Short passwords with no wordlist match.</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Breach to wordlist flow
         Teaching purpose: show that wordlists are recycled real passwords from
         breaches, which learners would otherwise misunderstand as an invented list. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 780 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Breach to wordlist flow">
            <!-- Boxes -->
            <rect x="10"  y="35" width="170" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="210" y="35" width="170" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="410" y="35" width="170" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="610" y="35" width="170" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <!-- Arrows -->
            <line x1="180" y1="70" x2="205" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="380" y1="70" x2="405" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="580" y1="70" x2="605" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <!-- Labels -->
            <text x="95"  y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Site Breach</text>
            <text x="95"  y="85" text-anchor="middle" font-size="10" fill="var(--text-secondary)">e.g. RockYou 2009</text>
            <text x="295" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Leaked</text>
            <text x="295" y="85" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Plaintext passwords</text>
            <text x="495" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Compiled</text>
            <text x="495" y="85" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Into a wordlist</text>
            <text x="695" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Reused</text>
            <text x="695" y="85" text-anchor="middle" font-size="10" fill="var(--text-secondary)">In future attacks</text>
        </svg>
    </div>
</div>
HTML;

// TASK 3: Cracking Tools Conceptually
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Guessing, Hashing, Comparing</h2>

    <p>Passwords are rarely stored in plain text. Instead, systems store a hash, the output of a one way function applied to the password. A hash cannot be reversed directly back into the original password.</p>

    <p>Cracking tools do not decrypt hashes. They take each wordlist entry, run it through the same hash function, and compare the result to the target hash. If the two match, the guess was correct.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Guess and Compare, Never Decrypt</h4>
        <p>A tool never reverses a hash. It hashes millions of candidate passwords and checks each result against the stolen hash until one matches.</p>
    </div>

    <h3>Hashcat vs John the Ripper</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Tool</th>
                <th>Primary Strength</th>
                <th>Typical Use Case</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Hashcat</strong></td>
                <td>GPU accelerated speed</td>
                <td>Cracking large hash sets very quickly.</td>
            </tr>
            <tr>
                <td><strong>John the Ripper</strong></td>
                <td>Flexible hash format detection</td>
                <td>Identifying and cracking many different hash types.</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: Hash comparison flow
         Teaching purpose: show cracking as comparison rather than decryption,
         which learners would otherwise misunderstand as reversing the hash. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 780 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Hash comparison flow">
            <rect x="10"  y="35" width="170" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="210" y="35" width="170" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="410" y="35" width="170" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="610" y="35" width="170" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <line x1="180" y1="70" x2="205" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="380" y1="70" x2="405" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <line x1="580" y1="70" x2="605" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <defs>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <text x="95"  y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Wordlist Entry</text>
            <text x="95"  y="85" text-anchor="middle" font-size="10" fill="var(--text-secondary)">e.g. dragon</text>
            <text x="295" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Hash Function</text>
            <text x="295" y="85" text-anchor="middle" font-size="10" fill="var(--text-secondary)">One way transform</text>
            <text x="495" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Compare</text>
            <text x="495" y="85" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Against target hash</text>
            <text x="695" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Match?</text>
            <text x="695" y="85" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Yes or no</text>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Speed matters because more guesses per second means more of the possibility space gets tested. This is why GPU acceleration made tools like Hashcat so effective.</p>
    </div>
</div>
HTML;

// TASK 4: Rules Based Mutations
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>One Word, Many Guesses</h2>

    <p>People rarely use a raw dictionary word as their password. They tend to vary it in predictable ways, adding a year, capitalizing the first letter, or swapping letters for similar looking symbols.</p>

    <p>A mutation rule is a predefined transformation applied automatically to every entry in a wordlist. Instead of collecting new words, rules reshape the words you already have, similar to filing small notches into existing keys instead of finding new ones.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> The Multiplier Effect</h4>
        <p>A wordlist of a few thousand words combined with a modest rule set can generate billions of effective guesses, since each rule produces a new variation of every single entry.</p>
    </div>

    <h3>Common Mutation Rules</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Rule Type</th>
                <th>Before</th>
                <th>After</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Append year</td>
                <td>dragon</td>
                <td>dragon2011</td>
            </tr>
            <tr>
                <td>Capitalize first letter</td>
                <td>dragon</td>
                <td>Dragon</td>
            </tr>
            <tr>
                <td><strong>Leetspeak</strong> substitution</td>
                <td>dragon</td>
                <td>dr4g0n</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: One word branching into mutated candidates
         Teaching purpose: show that one base word generates many candidate
         guesses, which learners would otherwise misunderstand as needing
         separate wordlists for every variation. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 780 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Rule based mutation branching">
            <rect x="10" y="80" width="150" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="85" y="110" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">dragon</text>

            <line x1="160" y1="105" x2="260" y2="30" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <line x1="160" y1="105" x2="260" y2="105" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <line x1="160" y1="105" x2="260" y2="180" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <defs>
                <marker id="arr4" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>

            <rect x="270" y="5"  width="180" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="270" y="80" width="180" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <rect x="270" y="155" width="180" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>

            <text x="360" y="35"  text-anchor="middle" font-size="13" fill="var(--text-primary)">dragon2011</text>
            <text x="360" y="110" text-anchor="middle" font-size="13" fill="var(--text-primary)">Dragon</text>
            <text x="360" y="185" text-anchor="middle" font-size="13" fill="var(--text-primary)">dr4g0n</text>
        </svg>
    </div>
</div>
HTML;

// TASK 5: Wordlist Attack Strategy and Limitations
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>When It Works, When It Fails</h2>

    <p>Wordlist attacks succeed against passwords that are common, reused, or predictably mutated from a common base. They struggle against long, random, unique passwords that never appear in any breach and follow no predictable pattern.</p>

    <p>A giant keyring built from other people's keys is useless against a custom vault combination that was never used anywhere before. This is exactly why password strategy matters as much as any technical defense.</p>

    <h3>When Wordlist Attacks Succeed vs Fail</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Scenario</th>
                <th>Outcome</th>
                <th>Why</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Reused or common password</td>
                <td>Cracked quickly</td>
                <td>Already exists in a wordlist or matches a common rule.</td>
            </tr>
            <tr>
                <td>Long random unique password</td>
                <td>Attack fails</td>
                <td>Never appears in any wordlist and follows no predictable rule.</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Defensive Takeaway</h4>
        <p>Defenders should rely on long unique passwords, a password manager, salted hashing on the server side, and multi factor authentication rather than hoping a password is obscure enough to avoid every wordlist.</p>
    </div>
</div>
HTML;

// TASK 6: Practical
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>You have intercepted a hash captured during a simulated penetration test. A small wordlist of candidate passwords is available, but the raw list alone will not crack it.</p>

    <p>Use the Password Cracker Console to test the wordlist as is, then apply a mutation rule to see how it transforms each candidate. Find the correct rule to crack the hash and reveal the flag.</p>

    <div class="practical-launch-wrapper">
        <a href="wordlist-attacks-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Password Cracker Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You now understand why wordlist attacks remain one of the most effective password cracking techniques in use today. Wordlists like RockYou exist because breached passwords are recycled, cracking tools work by hashing guesses and comparing results, and rule based mutations turn a small list into an enormous set of effective guesses.</p>

    <p>This same understanding protects you as a defender. Knowing how attackers think about wordlists and mutations makes it obvious why long unique passwords, salting, and multi factor authentication matter so much in practice.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Wordlists are built from real passwords leaked in past breaches, such as RockYou.</li>
        <li>Cracking tools hash each guess and compare it to the target hash, they never decrypt.</li>
        <li>Rule based mutations multiply a wordlist into billions of effective candidate guesses.</li>
        <li>Wordlist attacks fail against long, random, unique passwords with no predictable pattern.</li>
        <li>Salting, unique passwords, and multi factor authentication are the strongest practical defenses.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
