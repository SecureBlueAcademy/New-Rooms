<?php
// [topic-slug].php = api-security-engineering.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'api-security-engineering',
    'title'           => 'API Security Engineering',
    'description'     => 'Design the engineering controls that secure REST and GraphQL APIs, from gateway design to OAuth scopes, rate limiting, schema enforcement, and inventory management.',
    'icon'            => 'fas fa-plug-circle-bolt',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic HTTP and REST knowledge', 'Basic authentication concepts'],
    'learning_objectives' => [
        'Identify the API attack surface using the OWASP API Security Top 10',
        'Design an API gateway that centrally enforces authentication, rate limiting, and logging',
        'Apply OAuth 2.0 scopes and a full token validation sequence',
        'Select and apply the right rate limiting algorithm for a given API',
        'Enforce input validation through schema based whitelisting',
        'Maintain an API inventory to prevent shadow and zombie APIs',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/api-security-engineering-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'The API Attack Surface'],
    ['id' => 'task3', 'title' => 'Designing the API Gateway'],
    ['id' => 'task4', 'title' => 'OAuth 2.0 Scopes and Token Validation'],
    ['id' => 'task5', 'title' => 'Rate Limiting Strategies'],
    ['id' => 'task6', 'title' => 'Input Validation and Schema Enforcement'],
    ['id' => 'task7', 'title' => 'API Inventory and Lifecycle Management'],
    ['id' => 'task8', 'title' => 'Practical'],
    ['id' => 'task9', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'api_security_engineering_progress',
    'instagram_takeaways'  => [
        '✓ The OWASP API Security Top 10 and the API attack surface',
        '✓ Centralized enforcement through API gateway design',
        '✓ OAuth 2.0 scopes and full token validation sequences',
        '✓ Rate limiting algorithms and schema based input validation',
        '✓ Preventing shadow and zombie APIs through inventory management',
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
        ['id' => 'q1', 'text' => 'What is the term for a vulnerability where a user can access another user\'s data by changing an ID in the request?'],
        ['id' => 'q2', 'text' => 'What is the OWASP API Security Top 10 vulnerability where an endpoint returns more data than the client actually needs?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What component sits between clients and backend services to centrally enforce authentication, rate limiting, and logging?'],
        ['id' => 'q4', 'text' => 'What is the term for an attacker reaching a backend service directly, skipping the gateway\'s controls?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What OAuth 2.0 concept limits a token to a specific set of permissions?'],
        ['id' => 'q6', 'text' => 'What security principle states a token or user should be granted only the permissions needed?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'What rate limiting algorithm allows short bursts of traffic by spending saved up tokens over time?'],
        ['id' => 'q8', 'text' => 'What term describes limiting requests within a fixed time interval that resets on a schedule?'],
    ],
    'task6' => [
        ['id' => 'q9',  'text' => 'What attack occurs when extra unauthorized fields in a request body get accepted and applied to an object?'],
        ['id' => 'q10', 'text' => 'What validation approach only accepts explicitly allowed input and rejects everything else by default?'],
    ],
    'task7' => [
        ['id' => 'q11', 'text' => 'What term describes an undocumented API endpoint that exists outside official inventory tracking?'],
        ['id' => 'q12', 'text' => 'What term describes a deprecated API that is still reachable and unmonitored?'],
    ],
    'task8' => [
        ['id' => 'q13', 'text' => 'Enter the flag revealed after hardening the gateway.'],
    ],
    'task9' => [
        ['id' => 'q14', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Every API you expose is a direct line into your application's business logic. Unlike a web page, which filters what a user can do through buttons and forms, an API endpoint will do exactly what it is told, by anyone who can reach it and craft the right request. Securing APIs means designing controls at the engineering level rather than hoping the front end enforces the rules.</p>

    <p>By the end of this room, you will be able to design an API gateway, apply OAuth 2.0 scopes correctly, choose the right rate limiting strategy, enforce input validation through schema whitelisting, and maintain an inventory that prevents forgotten APIs from becoming a liability. A hands on gateway configuration lab is included to apply these controls directly.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Identify the API attack surface using the OWASP API Security Top 10.</li>
        <li>Design an API gateway that centrally enforces authentication, rate limiting, and logging.</li>
        <li>Apply OAuth 2.0 scopes and a full token validation sequence.</li>
        <li>Select the right rate limiting algorithm for a given API.</li>
        <li>Enforce input validation through schema based whitelisting.</li>
        <li>Maintain an API inventory to prevent shadow and zombie APIs.</li>
    </ul>
</div>
HTML;

// TASK 2: The API Attack Surface
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Every Endpoint Is Its Own Front Door</h2>

    <p>A traditional web application often has a single point of entry: the login page, followed by a handful of screens. An API is different. Each endpoint is an independent path into the system, and each one needs to be secured on its own terms rather than relying on a shared front door.</p>

    <p>Think of an API as a warehouse with many loading docks instead of one front entrance. A single guard at the main door does nothing to protect a dock around the back that nobody remembered to lock.</p>

    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Client accessing multiple independent API endpoints">
            <!-- Client -->
            <rect x="20" y="90" width="120" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="80" y="120" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Client</text>
            <!-- Three endpoints, each with its own guard -->
            <rect x="320" y="20" width="180" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="410" y="42" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">/users endpoint</text>
            <text x="410" y="58" text-anchor="middle" font-size="10" fill="var(--text-secondary)">needs its own guard</text>

            <rect x="320" y="90" width="180" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="410" y="112" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">/payments endpoint</text>
            <text x="410" y="128" text-anchor="middle" font-size="10" fill="var(--text-secondary)">needs its own guard</text>

            <rect x="320" y="160" width="180" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="410" y="182" text-anchor="middle" font-size="12" font-weight="600" fill="var(--text-primary)">/orders endpoint</text>
            <text x="410" y="198" text-anchor="middle" font-size="10" fill="var(--text-secondary)">needs its own guard</text>

            <!-- Lines from client to each endpoint -->
            <line x1="145" y1="110" x2="315" y2="45"  stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="145" y1="115" x2="315" y2="115" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="145" y1="120" x2="315" y2="185" stroke="var(--text-secondary)" stroke-width="1.5"/>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Why This Matters</h4>
        <p>APIs bypass the UI entirely. A filter or restriction built into a front end web page provides zero protection against a request sent directly to the API with a tool like curl or Postman. Every control must live in the API itself or in front of it.</p>
    </div>

    <h3>The OWASP API Security Top 10</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Rank</th>
                <th>Vulnerability</th>
                <th>One line description</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>1</td><td>Broken Object Level Authorization (BOLA)</td><td>Changing an ID in a request exposes another user's data.</td></tr>
            <tr><td>2</td><td>Broken Authentication</td><td>Weak or missing checks let attackers impersonate valid users.</td></tr>
            <tr><td>3</td><td>Broken Object Property Level Authorization</td><td>Users can read or write fields they should not access.</td></tr>
            <tr><td>4</td><td>Unrestricted Resource Consumption</td><td>No limits on requests, payload size, or resource usage.</td></tr>
            <tr><td>5</td><td>Broken Function Level Authorization</td><td>Regular users can call admin only functions.</td></tr>
            <tr><td>6</td><td>Unrestricted Access to Sensitive Business Flows</td><td>Automated abuse of a legitimate but sensitive workflow.</td></tr>
            <tr><td>7</td><td>Server Side Request Forgery</td><td>The API is tricked into making requests on the attacker's behalf.</td></tr>
            <tr><td>8</td><td>Security Misconfiguration</td><td>Default settings, verbose errors, or missing hardening.</td></tr>
            <tr><td>9</td><td>Improper Inventory Management</td><td>Undocumented or outdated API versions remain reachable.</td></tr>
            <tr><td>10</td><td>Unsafe Consumption of APIs</td><td>Trusting data from third party APIs without validation.</td></tr>
        </tbody>
    </table>
</div>
HTML;

// TASK 3: Designing the API Gateway
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>One Front Desk for Every Visitor</h2>

    <p>An API gateway sits between clients and backend services, acting as the single enforcement point for authentication, rate limiting, and logging. Instead of every backend service reimplementing the same checks, the gateway handles them once, consistently, for every request.</p>

    <p>Think of the gateway as a building's front desk. Every visitor, regardless of which office they are heading to, checks in at the same desk first. This is far more reliable than expecting each office to independently check every visitor who wanders in.</p>

    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="API gateway enforcing checks before requests reach backend services">
            <rect x="20" y="85" width="110" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="75" y="115" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Client</text>

            <rect x="270" y="75" width="160" height="70" rx="8" fill="var(--surface)" stroke="var(--primary)" stroke-width="2"/>
            <text x="350" y="105" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">API Gateway</text>
            <text x="350" y="122" text-anchor="middle" font-size="10" fill="var(--text-secondary)">auth, rate limit, logging</text>

            <rect x="560" y="20" width="130" height="45" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="625" y="47" text-anchor="middle" font-size="11" fill="var(--text-primary)">Users Service</text>

            <rect x="560" y="90" width="130" height="45" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="625" y="117" text-anchor="middle" font-size="11" fill="var(--text-primary)">Payments Service</text>

            <rect x="560" y="160" width="130" height="45" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="625" y="187" text-anchor="middle" font-size="11" fill="var(--text-primary)">Orders Service</text>

            <line x1="135" y1="110" x2="265" y2="110" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="430" y1="95"  x2="555" y2="42"  stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="430" y1="110" x2="555" y2="112" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="430" y1="125" x2="555" y2="182" stroke="var(--text-secondary)" stroke-width="1.5"/>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Gateway Bypass Risk</h4>
        <p>If backend services remain directly reachable from the public internet, an attacker can skip the gateway entirely and reach a service with none of its protections applied. Backend services should only accept traffic that has already passed through the gateway.</p>
    </div>
</div>
HTML;

// TASK 4: OAuth 2.0 Scopes and Token Validation
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Keys That Only Open the Right Doors</h2>

    <p>OAuth 2.0 scopes define exactly what a token is permitted to do. Rather than issuing one token that can do everything, a well designed API issues tokens scoped to specific actions, such as <code>payments:read</code> or <code>payments:transfer</code>.</p>

    <p>Think of scopes as individual keys on a keyring rather than one master key. A payments read scope opens the door to view a balance. It does not open the door to move money.</p>

    <h3>The Token Validation Sequence</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Check</th>
                <th>What It Verifies</th>
                <th>Why It Matters</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Signature</td><td>The token was issued by a trusted authority and has not been altered.</td><td>Prevents forged or tampered tokens.</td></tr>
            <tr><td>Expiry</td><td>The token has not passed its valid lifetime.</td><td>Limits how long a stolen token remains useful.</td></tr>
            <tr><td>Issuer</td><td>The token came from the expected authorization server.</td><td>Blocks tokens issued by an untrusted source.</td></tr>
            <tr><td>Audience</td><td>The token was intended for this specific API.</td><td>Stops a token meant for one API being replayed against another.</td></tr>
            <tr><td>Scope</td><td>The token carries the permission the endpoint requires.</td><td>Enforces least privilege at the request level.</td></tr>
        </tbody>
    </table>

    <div style="margin: 20px 0;">
        <svg viewBox="0 0 700 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Sequential token validation checks">
            <rect x="10"  y="45" width="110" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="65" y="75" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Signature</text>

            <rect x="150" y="45" width="110" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="205" y="75" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Expiry</text>

            <rect x="290" y="45" width="110" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="345" y="75" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Issuer</text>

            <rect x="430" y="45" width="110" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="485" y="75" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Audience</text>

            <rect x="570" y="45" width="110" height="50" rx="8" fill="var(--surface)" stroke="var(--primary)" stroke-width="2"/>
            <text x="625" y="75" text-anchor="middle" font-size="11" font-weight="600" fill="var(--text-primary)">Scope</text>

            <line x1="120" y1="70" x2="145" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="260" y1="70" x2="285" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="400" y1="70" x2="425" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <line x1="540" y1="70" x2="565" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Scopes should be as narrow as the action requires. A token that only needs to check a balance should never be able to move money, even if the user behind it is fully authenticated.</p>
    </div>
</div>
HTML;

// TASK 5: Rate Limiting Strategies
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Controlling How Often a Client Can Knock</h2>

    <p>Rate limiting protects an API from being overwhelmed, whether by an accidental retry loop or a deliberate abuse attempt. Different algorithms make different tradeoffs between simplicity and fairness.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Algorithm</th>
                <th>How It Works</th>
                <th>Weakness</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Fixed window</td><td>Counts requests within a set interval that resets on a schedule.</td><td>Allows a burst right at the window boundary.</td></tr>
            <tr><td>Sliding window</td><td>Counts requests over a rolling time period rather than a fixed reset point.</td><td>More complex to implement and track accurately.</td></tr>
            <tr><td>Token bucket</td><td>Tokens refill at a steady rate and each request spends one token.</td><td>Requires tuning the refill rate to the endpoint's real needs.</td></tr>
        </tbody>
    </table>

    <p>The token bucket approach is worth understanding closely. Picture a bucket that refills with tokens at a steady rate. Each request spends one token. If the bucket runs dry, the client must wait for it to refill, but short bursts are tolerated as long as tokens are available.</p>

    <div style="margin: 20px 0;">
        <svg viewBox="0 0 500 220" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Token bucket filling and draining as requests are made">
            <!-- Bucket -->
            <path d="M150,40 L350,40 L330,190 L170,190 Z" fill="var(--surface)" stroke="var(--border)" stroke-width="2"/>
            <!-- Tokens inside -->
            <circle cx="220" cy="150" r="10" fill="var(--primary)"/>
            <circle cx="260" cy="150" r="10" fill="var(--primary)"/>
            <circle cx="240" cy="120" r="10" fill="var(--primary)"/>
            <circle cx="280" cy="120" r="10" fill="var(--primary)"/>
            <text x="250" y="210" text-anchor="middle" font-size="12" fill="var(--text-secondary)">Token Bucket</text>
            <!-- Refill arrow -->
            <line x1="250" y1="10" x2="250" y2="35" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <text x="330" y="20" text-anchor="middle" font-size="10" fill="var(--text-secondary)">refill rate</text>
            <!-- Outgoing request -->
            <line x1="360" y1="120" x2="430" y2="120" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <text x="430" y="105" text-anchor="middle" font-size="10" fill="var(--text-secondary)">1 request = 1 token</text>
            <defs>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Limiting by the Wrong Key</h4>
        <p>Limiting by IP address alone is unreliable, since many clients can share a single IP behind NAT or a corporate proxy. Rate limits are more effective when applied per authenticated client key or per token.</p>
    </div>
</div>
HTML;

// TASK 6: Input Validation and Schema Enforcement
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Rejecting Anything Outside the Lines</h2>

    <p>Schema enforcement defines the exact shape a request is allowed to take and rejects anything that does not match, rather than trying to sanitize unexpected input after the fact. This whitelisting approach is far more reliable than attempting to blacklist every possible bad input.</p>

    <p>Consider a signup request that is only supposed to contain a name, email, and password. If an attacker adds an extra field such as <code>isAdmin: true</code> and the backend blindly applies every field it receives to the new user object, the attacker has just granted themselves admin rights. This is called mass assignment, and schema enforcement prevents it by rejecting any field that was not explicitly defined.</p>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Key Point</h4>
        <p>Reject by default beats sanitize and accept. A schema that only allows explicitly defined fields makes an entire category of injection and mass assignment attacks structurally impossible, rather than relying on catching every bad input case individually.</p>
    </div>
</div>
HTML;

// TASK 7: API Inventory and Lifecycle Management
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <h2>Knowing Every Door You Have Ever Unlocked</h2>

    <p>An API inventory is the complete, current list of every endpoint your organization exposes, including its version and its intended lifecycle. Without one, engineering teams lose track of what is running, and forgotten endpoints quietly become risk.</p>

    <p>Think of the inventory as the full list of doors into a building, including ones that people forgot were ever unlocked. A door nobody remembers still opens just as easily for an attacker who finds it.</p>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Shadow and Zombie APIs</h4>
        <p>A shadow API is one that was deployed without ever being documented or tracked. A zombie API is one that was deprecated but never actually shut down, and remains reachable with none of the current monitoring or protections applied. Automated discovery and a strict deprecation policy are the primary defenses against both.</p>
    </div>
</div>
HTML;

// TASK 8: Practical
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>You have been handed access to the gateway configuration console for a payment transfer route, <code>POST /api/v1/payments/transfer</code>. The route is currently exposed with no rate limit, an overly broad OAuth scope, and no schema validation.</p>

    <p>Apply what you learned about gateway design, scopes, and rate limiting to correctly harden this route. Set the rate limit, scope, and schema validation controls to their correct values, then validate your configuration.</p>

    <div class="practical-launch-wrapper">
        <a href="api-security-engineering-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Gateway Configuration Lab</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 9: Conclusion
$task_contents[9] = <<<'HTML'
<div class="content-block">
    <p>You have now covered the core engineering controls behind API security: mapping the attack surface with the OWASP API Security Top 10, centralizing enforcement in a gateway, applying OAuth 2.0 scopes with a full token validation sequence, choosing the right rate limiting strategy, enforcing schema based input validation, and maintaining an inventory that prevents forgotten APIs from becoming risk.</p>

    <p>These controls work together. A gateway without rate limiting is incomplete. Scopes without proper token validation offer a false sense of security. An inventory without deprecation policy simply delays the problem. Treat each control as part of one coherent design rather than a checklist to complete in isolation.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Every API endpoint is an independent attack surface and needs its own enforcement.</li>
        <li>An API gateway centralizes authentication, rate limiting, and logging in one place.</li>
        <li>OAuth 2.0 scopes should follow least privilege, and tokens require a full validation sequence.</li>
        <li>Rate limiting algorithms trade off simplicity, fairness, and burst tolerance.</li>
        <li>Schema based whitelisting prevents mass assignment and injection by rejecting anything unexpected.</li>
        <li>An accurate API inventory prevents shadow and zombie APIs from becoming a liability.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA — engine renders everything from here.
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
