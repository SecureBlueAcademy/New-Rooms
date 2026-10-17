<?php
// ============================================================
// hash-types-identification.php — CYBRIXEN ROOM DATA FILE
// ============================================================

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'hash-identification',
    'title'           => 'Hash Types & Identification',
    'description'     => 'Learn how passwords are stored as hashes and how to identify MD5, SHA1, SHA256, NTLM, and bcrypt by their format.',
    'icon'            => 'fas fa-fingerprint',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Beginner',
    'estimated_time'  => '40 minutes',
    'prerequisites'   => ['Basic computer knowledge'],
    'learning_objectives' => [
        'Explain what a hash function does and why it cannot be reversed',
        'Identify common hash algorithms by their length and format',
        'Compare hashing algorithms based on cryptographic strength',
        'Explain why some algorithms are considered broken or unsafe for passwords',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/hash-types-identification-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'What is Hashing?'],
    ['id' => 'task3', 'title' => 'Reading a Hash Format'],
    ['id' => 'task4', 'title' => 'Meet the Algorithms'],
    ['id' => 'task5', 'title' => 'Broken, Fast, or Built for Passwords?'],
    ['id' => 'task6', 'title' => 'Practical'],
    ['id' => 'task7', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'hash_identification_progress',
    'instagram_takeaways'  => [
        '✓ Hashing turns passwords into one way digests',
        '✓ Hash length and format reveal the algorithm used',
        '✓ MD5, SHA1, NTLM, SHA256, and bcrypt each behave differently',
        '✓ Salting and slow algorithms defend against cracking',
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
        ['id' => 'q1', 'text' => 'What is the technical term for a hash function\'s output?'],
        ['id' => 'q2', 'text' => 'What type of function is a hash function, in terms of reversibility?'],
        ['id' => 'q3', 'text' => 'What property ensures the same input always produces the same hash?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What character set do most hash outputs use?'],
        ['id' => 'q5', 'text' => 'How many characters long is an MD5 hash?'],
        ['id' => 'q6', 'text' => 'What character sequence identifies a bcrypt hash?'],
    ],
    'task4' => [
        ['id' => 'q7', 'text' => 'What does NTLM stand for?'],
        ['id' => 'q8', 'text' => 'Which hashing algorithm is commonly used to store Windows passwords?'],
        ['id' => 'q9', 'text' => 'Which algorithm produces a 256-bit hash?'],
    ],
    'task5' => [
        ['id' => 'q10', 'text' => 'What type of table allows attackers to quickly reverse unsalted hashes?'],
        ['id' => 'q11', 'text' => 'What random value can be added to a hash to prevent rainbow table attacks?'],
        ['id' => 'q12', 'text' => 'Which algorithm covered in this room is specifically designed to be slow for password storage?'],
    ],
    'task6' => [
        ['id' => 'q13', 'text' => 'Enter the flag from the Breach Triage report.'],
    ],
    'task7' => [
        ['id' => 'q14', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Every time you log into a website, your password is almost never stored as plain text. Instead, systems store a hash, a fixed length string produced by feeding your password through a mathematical function. If a database is ever stolen, the strength of that hash often decides whether attackers walk away with nothing or with every password on the list.</p>

    <p>By the end of this room you will be able to look at an unlabeled hash and identify which algorithm produced it, based only on its length and format. You will also understand why some algorithms are considered broken while others remain the standard for safe password storage. A hands on lab lets you practice this skill on real looking breach data.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain what a hash function does and why it cannot be reversed.</li>
        <li>Identify common hash algorithms by their length and format.</li>
        <li>Compare hashing algorithms based on cryptographic strength.</li>
        <li>Explain why some algorithms are considered broken or unsafe for passwords.</li>
        <li>Apply hash identification skills to triage real hash samples.</li>
    </ul>
</div>
HTML;

// TASK 2: What is Hashing?
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Turning Passwords Into Digests</h2>

    <p>A hash function takes any input, such as a password, and converts it into a fixed length string called a <strong>digest</strong>. No matter how long or short the original password is, the digest is always the same length for a given algorithm.</p>

    <p>Think of a hash function like a paper shredder. You can feed a document into a shredder and get a pile of shredded strips, but you cannot feed the strips back in and get the original document. Hashing works the same way. It is a one way function, meaning there is no mathematical way to reverse a digest back into the original password.</p>

    <p>Hash functions are also deterministic. This means the same input will always produce the exact same digest every single time. This is what allows a login system to check your password without ever storing it. It simply hashes what you typed and compares the result to the stored digest.</p>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Hashing is Not Encryption</h4>
        <p>Encryption is designed to be reversed with the correct key. Hashing is designed never to be reversed at all. Password systems use hashing precisely because the original password should never need to come back.</p>
    </div>

    <!-- SVG: One way hash flow diagram
         Teaching purpose: show the learner that hashing only flows in one direction from
         password to digest, which they would otherwise misunderstand as a reversible process
         similar to encryption. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="One way hashing flow">
            <!-- Input box -->
            <rect x="20" y="40" width="160" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="100" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Password</text>
            <text x="100" y="82" text-anchor="middle" font-size="11" fill="var(--text-secondary)">"sunshine22"</text>

            <!-- Hash function box -->
            <rect x="270" y="30" width="180" height="80" rx="8" fill="var(--surface)" stroke="var(--primary)" stroke-width="1.5"/>
            <text x="360" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Hash Function</text>
            <text x="360" y="82" text-anchor="middle" font-size="11" fill="var(--text-secondary)">one way only</text>

            <!-- Output box -->
            <rect x="520" y="40" width="160" height="60" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="600" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Digest</text>
            <text x="600" y="82" text-anchor="middle" font-size="10" fill="var(--text-secondary)">5f4dcc3b5aa7...</text>

            <!-- Forward arrow only -->
            <line x1="180" y1="70" x2="265" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrHash)"/>
            <line x1="450" y1="70" x2="515" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arrHash)"/>

            <!-- Blocked reverse path -->
            <line x1="600" y1="115" x2="100" y2="115" stroke="var(--text-secondary)" stroke-width="1.2" stroke-dasharray="4,4"/>
            <circle cx="350" cy="115" r="10" fill="none" stroke="var(--text-secondary)" stroke-width="1.2"/>
            <line x1="343" y1="122" x2="357" y2="108" stroke="var(--text-secondary)" stroke-width="1.2"/>
            <text x="350" y="135" text-anchor="middle" font-size="10" fill="var(--text-secondary)">no reverse path</text>

            <defs>
                <marker id="arrHash" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>
</div>
HTML;

// TASK 3: Reading a Hash's Format
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Clues Hidden in the Hash</h2>

    <p>You do not need special tools to make a strong first guess at a hash's algorithm. Most hashes are written in <strong>hexadecimal</strong>, meaning they only use the characters 0 through 9 and a through f. What usually gives the algorithm away is the total length of the string and any special prefix it carries.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Algorithm</th>
                <th>Output Length</th>
                <th>Character Set</th>
                <th>Example</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>MD5</td>
                <td>32 characters</td>
                <td>hexadecimal</td>
                <td>5f4dcc3b5aa765d61d8327deb882cf99</td>
            </tr>
            <tr>
                <td>SHA1</td>
                <td>40 characters</td>
                <td>hexadecimal</td>
                <td>5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8</td>
            </tr>
            <tr>
                <td>NTLM</td>
                <td>32 characters</td>
                <td>hexadecimal, often uppercase</td>
                <td>8846F7EAEE8FB117AD06BDD830B7586C</td>
            </tr>
            <tr>
                <td>SHA256</td>
                <td>64 characters</td>
                <td>hexadecimal</td>
                <td>5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d</td>
            </tr>
            <tr>
                <td>bcrypt</td>
                <td>60 characters</td>
                <td>base64 style, starts with $2b$</td>
                <td>$2b$12$KIXQ4Yh6vG5x9zL8mF3n1O7wYtR2sVeUdCpNjBhGkLxTfMz1qWnKe</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Length Is Not Always Enough</h4>
        <p>Notice that MD5 and NTLM are both 32 characters long. Length alone cannot always tell them apart. Where the hash was found, such as a Windows system versus a web application database, often provides the missing context.</p>
    </div>
</div>
HTML;

// TASK 4: Meet the Algorithms
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>A Lineup of Common Algorithms</h2>

    <p>Each algorithm below was built for a different time and a different purpose. Knowing where each one tends to show up helps you identify it even faster than counting characters alone.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Algorithm</th>
                <th>Year Introduced</th>
                <th>Typical Use Today</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>MD5</td>
                <td>1992</td>
                <td>Legacy systems and file checksums, no longer safe for passwords</td>
            </tr>
            <tr>
                <td>SHA1</td>
                <td>1995</td>
                <td>Older certificates and legacy systems, being phased out</td>
            </tr>
            <tr>
                <td>NTLM</td>
                <td>1993</td>
                <td>Windows authentication, especially older domain environments</td>
            </tr>
            <tr>
                <td>SHA256</td>
                <td>2001</td>
                <td>File integrity checks, blockchain, and general purpose hashing</td>
            </tr>
            <tr>
                <td>bcrypt</td>
                <td>1999</td>
                <td>Modern password storage in web applications</td>
            </tr>
        </tbody>
    </table>

    <p><strong>NTLM</strong>, which stands for NT LAN Manager, is the hashing scheme Windows has used for decades to store and verify domain credentials. Its 32 character hexadecimal output is often confused with MD5, so location and system context matter when identifying it.</p>
</div>
HTML;

// TASK 5: Broken, Fast, or Built for Passwords?
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Why Speed Is the Enemy of Password Security</h2>

    <p>MD5 and SHA1 are considered <strong>cryptographically broken</strong>. Researchers have demonstrated collisions, meaning two different inputs can produce the same digest, which undermines their reliability for security purposes.</p>

    <p>SHA256 and NTLM are not broken in the same way, but they share a different weakness. They were designed to be fast, which is great for checksums but terrible for password storage. A modern graphics card can compute billions of these hashes per second, making it possible to try every password in a leaked dictionary almost instantly.</p>

    <div class="warning-box">
        <h4><i class="fas fa-exclamation-triangle"></i> Rainbow Tables and GPU Cracking</h4>
        <p>Attackers use precomputed lists called rainbow tables to reverse unsalted hashes almost instantly. Even without a rainbow table, fast algorithms like MD5 and SHA256 can be brute forced at massive scale using ordinary consumer graphics hardware.</p>
    </div>

    <p><strong>bcrypt</strong> takes the opposite approach. It is deliberately slow, and it automatically adds a random value called a <strong>salt</strong> to every password before hashing it. This means two users with the same password end up with completely different stored hashes, and each hash takes noticeably longer to compute, which makes large scale cracking impractical.</p>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>bcrypt resists cracking not because it is unbreakable, but because it is intentionally slow and salted. Speed is a feature for checksums and a liability for password storage.</p>
    </div>
</div>
HTML;

// TASK 6: Practical (Breach Triage)
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <p>A breach report has landed on your desk containing five password hashes pulled from different compromised systems. None of them are labeled. Your job is to identify the algorithm behind each hash and classify it as either high risk or low risk based on how easily it could be cracked.</p>

    <p>Use everything you learned about hash length, character format, and algorithm strength to triage the queue. Once every hash is correctly identified and classified, the full breach report will unlock.</p>

    <div class="practical-launch-wrapper">
        <a href="hash-types-identification-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Breach Triage</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 7: Conclusion
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You can now look at an unlabeled hash and make a confident, informed guess about which algorithm produced it, simply by reading its length and format. More importantly, you understand why that identification matters. Not every hash carries the same level of risk, and knowing the difference is the first step toward fixing weak password storage before an attacker finds it.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Hash functions produce a fixed length digest and cannot be reversed.</li>
        <li>Hash length and character format are the fastest clues to an algorithm's identity.</li>
        <li>MD5 and SHA1 are cryptographically broken due to demonstrated collisions.</li>
        <li>SHA256 and NTLM are fast algorithms, which makes them risky for password storage even though they are not broken.</li>
        <li>bcrypt defends against cracking through deliberate slowness and automatic salting.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
