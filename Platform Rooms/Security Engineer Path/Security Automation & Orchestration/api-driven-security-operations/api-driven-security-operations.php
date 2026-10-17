<?php
// api-driven-security-operations.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'api-driven-security-operations',
    'title'           => 'API-Driven Security Operations',
    'description'     => 'Learn to authenticate, parse, enrich, and automate security operations through integrated APIs and webhooks.',
    'icon'            => 'fas fa-plug-circle-bolt',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic networking concepts', 'Basic understanding of security alerts and SOC workflows'],
    'learning_objectives' => [
        'Explain REST API authentication methods used by security tools',
        'Parse JSON API responses to extract security-relevant fields',
        'Describe how enrichment pipelines add context to raw alerts',
        'Explain how webhooks trigger automated security responses',
        'Describe resilience patterns for integration architecture',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/api-driven-security-operations-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Authenticating to Security APIs'],
    ['id' => 'task3', 'title' => 'Parsing JSON Responses'],
    ['id' => 'task4', 'title' => 'Building Enrichment Pipelines'],
    ['id' => 'task5', 'title' => 'Webhooks and Automated Response'],
    ['id' => 'task6', 'title' => 'Designing Resilient Integration Architecture'],
    ['id' => 'task7', 'title' => 'Practical'],
    ['id' => 'task8', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'api_driven_security_operations_progress',
    'instagram_takeaways'  => [
        '✓ API keys, bearer tokens, and OAuth for security tool authentication',
        '✓ Parsing JSON responses to extract security context',
        '✓ Enrichment pipelines that add context to raw alerts',
        '✓ Webhooks and automated response triggers',
        '✓ Designing resilient integrations that survive outages',
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
        ['id' => 'q1', 'text' => 'What OAuth flow is commonly used for machine to machine API authentication?'],
        ['id' => 'q2', 'text' => 'What HTTP header is commonly used to send a bearer token?'],
        ['id' => 'q3', 'text' => 'What term describes a secure storage system used to avoid hardcoding API credentials?'],
    ],
    'task3' => [
        ['id' => 'q4', 'text' => 'What data format do most modern security APIs return responses in?'],
        ['id' => 'q5', 'text' => 'What term describes writing code that gracefully handles missing or malformed fields?'],
    ],
    'task4' => [
        ['id' => 'q6', 'text' => 'What is the term for adding contextual data such as geolocation or reputation to a raw alert?'],
        ['id' => 'q7', 'text' => 'What type of API call retrieves reputation or geolocation data about an IP address?'],
    ],
    'task5' => [
        ['id' => 'q8', 'text' => 'What term describes an API automatically sending data to your system when an event occurs?'],
        ['id' => 'q9', 'text' => 'What is the opposite model, where your system repeatedly checks an API for updates?'],
        ['id' => 'q10', 'text' => 'What security mechanism verifies a webhook payload has not been tampered with?'],
    ],
    'task6' => [
        ['id' => 'q11', 'text' => 'What term describes a component that stops calls to a failing service to prevent cascading failures?'],
        ['id' => 'q12', 'text' => 'What term describes an alternate data source used when the primary API is unavailable?'],
    ],
    'task7' => [
        ['id' => 'q13', 'text' => 'Enter the flag revealed after correctly triaging all webhook events.'],
    ],
    'task8' => [
        ['id' => 'q14', 'text' => 'Type <strong>"complete"</strong> to finish this room.'],
    ],
];

// ========================
// 6. TASK CONTENT BLOCKS
// ========================

// TASK 1: Introduction
$task_contents[1] = <<<'HTML'
<div class="content-block">
    <p>Modern security operations centers process thousands of alerts a day, far more than any analyst could triage by hand. API driven security operations is the practice of connecting security tools together through APIs and webhooks so that alerts are authenticated, enriched with context, and routed to automated responses without a human clicking through every step.</p>

    <p>By the end of this room, you will be able to authenticate to security APIs, parse JSON responses to pull out the fields that matter, build enrichment pipelines that add context to raw alerts, trigger automated responses through webhooks, and design an integration architecture that keeps working even when one of its services goes down. A hands on practical is included to put these skills into practice.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Explain REST API authentication methods used by security tools.</li>
        <li>Parse JSON API responses to extract security relevant fields.</li>
        <li>Describe how enrichment pipelines add context to raw alerts.</li>
        <li>Explain how webhooks trigger automated security responses.</li>
        <li>Describe resilience patterns for integration architecture.</li>
    </ul>
</div>
HTML;

// TASK 2: Authenticating to Security APIs
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Proving Your Tools Are Allowed to Talk</h2>

    <p>Before any security tool can pull data from an API or push an action to one, it has to prove it is allowed to be there. This is authentication, and it works the same way for machines as it does for people, just without a login screen.</p>

    <p>Think of an <strong>API key</strong> like a building keycard. It is issued once, it works every time you swipe it, and if someone steals it, they have the same access you do until it is revoked. A <strong>bearer token</strong> is closer to a visitor badge with an expiry time printed on it. It grants access only for a limited window before it needs to be renewed.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Method</th>
                <th>How It Works</th>
                <th>Common Use Case</th>
                <th>Risk If Leaked</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>API Key</td>
                <td>A static string sent in a header or query parameter with every request.</td>
                <td>Simple threat intel or lookup integrations.</td>
                <td>Full access until manually revoked, no expiry.</td>
            </tr>
            <tr>
                <td>Bearer Token</td>
                <td>A token issued after login, sent in the Authorization header.</td>
                <td>Session based integrations with short lived access.</td>
                <td>Limited window of exposure before it expires.</td>
            </tr>
            <tr>
                <td>OAuth 2.0</td>
                <td>A structured flow that issues short lived access tokens, often without ever exposing a password.</td>
                <td>Machine to machine integrations between security platforms.</td>
                <td>Lower risk, since tokens are scoped and expire automatically.</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: OAuth client credentials handshake
         Teaching purpose: show the learner that obtaining a token is a separate request
         from using it, which they would otherwise misunderstand as a single login step. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 200" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="OAuth client credentials flow">
            <!-- Actors -->
            <rect x="20" y="20" width="150" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="95" y="50" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Security Tool</text>

            <rect x="590" y="20" width="150" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="665" y="50" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Auth Server</text>

            <!-- Step 1 -->
            <line x1="170" y1="55" x2="585" y2="55" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr1)"/>
            <text x="380" y="45" text-anchor="middle" font-size="11" fill="var(--text-secondary)">1. Request token with client ID and secret</text>

            <!-- Step 2 -->
            <line x1="585" y1="90" x2="170" y2="90" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <text x="380" y="105" text-anchor="middle" font-size="11" fill="var(--text-secondary)">2. Returns short lived access token</text>

            <rect x="20" y="130" width="150" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="95" y="160" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Security Tool</text>

            <rect x="590" y="130" width="150" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="665" y="160" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Resource API</text>

            <line x1="170" y1="155" x2="585" y2="155" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <text x="380" y="145" text-anchor="middle" font-size="11" fill="var(--text-secondary)">3. Uses token in Authorization header</text>

            <defs>
                <marker id="arr1" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Never Hardcode Credentials</h4>
        <p>API keys and secrets should live in a dedicated vault or secrets manager, never directly inside a script or configuration file committed to source control.</p>
    </div>
</div>
HTML;

// TASK 3: Parsing JSON Responses
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Reading What the API Sends Back</h2>

    <p>Nearly every modern security API responds in <strong>JSON</strong>, a structured text format built from keys and values, nested objects, and arrays. Parsing JSON means turning that structured text into data your pipeline can actually use, such as pulling a single reputation score out of a much larger response.</p>

    <p>Here is a simplified threat intelligence API response for an IP address lookup:</p>

    <div class="info-box">
        <h4><i class="fas fa-code"></i> Sample Response</h4>
        <p>The response below nests the useful fields inside an "indicator" object. A parser needs to walk into that nested object rather than expecting the fields at the top level.</p>
    </div>

    <table class="content-table">
        <thead>
            <tr>
                <th>Field Path</th>
                <th>Meaning</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>indicator.reputation_score</td>
                <td>A numeric score representing how malicious the IP has been observed to be.</td>
            </tr>
            <tr>
                <td>indicator.geolocation.country</td>
                <td>The country the IP is registered to.</td>
            </tr>
            <tr>
                <td>indicator.asn_owner</td>
                <td>The organization that owns the network the IP belongs to.</td>
            </tr>
        </tbody>
    </table>

    <p>Real world responses rarely arrive perfectly formed. A field might be missing, an array might be empty, or a nested object might not exist for a given record. Writing code that checks for these cases before using a value, rather than assuming it is always present, is called <strong>defensive programming</strong>.</p>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Common Failure</h4>
        <p>A pipeline that assumes every field always exists will crash the moment one API response is incomplete, taking down the whole enrichment process with it.</p>
    </div>
</div>
HTML;

// TASK 4: Building Enrichment Pipelines
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Turning a Bare Alert Into Something Useful</h2>

    <p>A raw alert on its own is often just an IP address and a timestamp. That tells an analyst almost nothing about whether it matters. <strong>Enrichment</strong> is the process of automatically adding context to that raw alert before a human ever sees it, so the analyst starts with a clear picture instead of a blank one.</p>

    <p>Consider the difference between these two versions of the same alert.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Raw Alert</th>
                <th>Enriched Alert</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>IP: 203.0.113.55, Timestamp: 14:32 UTC</td>
                <td>IP: 203.0.113.55, Timestamp: 14:32 UTC, Reputation: Malicious (92/100), Country: Country X, ASN Owner: Hosting Provider Y, Prior Sightings: 3 in last 30 days</td>
            </tr>
        </tbody>
    </table>

    <!-- SVG: enrichment pipeline stages
         Teaching purpose: show the learner that enrichment is a multi-step pipeline
         of separate calls, which they would otherwise misunderstand as one instant lookup. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 130" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Enrichment pipeline stages">
            <rect x="10" y="30" width="160" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="90" y="60" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Raw Alert</text>
            <text x="90" y="80" text-anchor="middle" font-size="10" fill="var(--text-secondary)">IP + timestamp only</text>

            <line x1="170" y1="65" x2="205" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#e1)"/>

            <rect x="210" y="30" width="160" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="290" y="60" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Threat Intel API</text>
            <text x="290" y="80" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Reputation lookup</text>

            <line x1="370" y1="65" x2="405" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#e2)"/>

            <rect x="410" y="30" width="160" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="490" y="60" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Enrichment Engine</text>
            <text x="490" y="80" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Merges fields</text>

            <line x1="570" y1="65" x2="605" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#e3)"/>

            <rect x="610" y="30" width="140" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="680" y="60" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Enriched Alert</text>
            <text x="680" y="80" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Ready for analyst</text>

            <defs>
                <marker id="e1" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto"><path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/></marker>
                <marker id="e2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto"><path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/></marker>
                <marker id="e3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto"><path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/></marker>
            </defs>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Why This Matters</h4>
        <p>Enrichment reduces analyst fatigue. Instead of manually looking up context for every alert, the analyst opens an alert that already tells them whether it deserves attention.</p>
    </div>
</div>
HTML;

// TASK 5: Webhooks and Automated Response
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Letting Events Trigger Actions Automatically</h2>

    <p>A <strong>webhook</strong> is a way for one system to automatically send data to another the moment something happens, rather than waiting to be asked. Instead of your tool repeatedly checking an API for updates, a technique called <strong>polling</strong>, the API pushes the event to you as soon as it occurs.</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Model</th>
                <th>Latency</th>
                <th>Resource Cost</th>
                <th>Best Fit</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Webhook</td>
                <td>Near instant</td>
                <td>Low, only active when an event fires</td>
                <td>Real time security response</td>
            </tr>
            <tr>
                <td>Polling</td>
                <td>Delayed by the polling interval</td>
                <td>Higher, constant repeated requests</td>
                <td>Non urgent, periodic data syncs</td>
            </tr>
        </tbody>
    </table>

    <p>In a security context, a webhook event might report a detected malware sample, a brute force login attempt, or unusual API usage. Each event type can be mapped to a specific automated response, such as isolating a host or blocking an IP address, so the reaction happens in seconds instead of after an analyst finally reviews the queue.</p>

    <div class="info-box">
        <h4><i class="fas fa-shield-halved"></i> Verify Before You Trust</h4>
        <p>A webhook receiver should check a cryptographic signature on every incoming payload, called signature verification, to confirm the event genuinely came from the expected source and was not spoofed by an attacker.</p>
    </div>
</div>
HTML;

// TASK 6: Designing Resilient Integration Architecture
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Keeping the Toolchain Running When One Piece Fails</h2>

    <p>A security toolchain is rarely a single API call. It is often a chain: an alert triggers a threat intel lookup, which feeds a ticketing system, which triggers a notification service. If any one of those services goes down and the chain has no plan for it, the entire pipeline can stall.</p>

    <p>Think of it like a relay race. If one runner fails to show up, a well designed team has a backup runner ready, rather than letting the whole race stop.</p>

    <p>A few patterns keep a chained integration resilient:</p>
    <ul>
        <li><strong>Timeouts</strong> prevent a pipeline from waiting forever on a service that never responds.</li>
        <li><strong>Retries</strong> handle brief, temporary failures by trying again after a short delay.</li>
        <li>A <strong>circuit breaker</strong> stops sending requests to a service that keeps failing, to avoid piling up failed calls and making the outage worse.</li>
        <li>A <strong>fallback</strong> source, such as a cached result or a secondary provider, keeps the pipeline functional when the primary API is unavailable.</li>
    </ul>

    <!-- SVG: circuit breaker rerouting around a failed service
         Teaching purpose: show the learner that a circuit breaker reroutes traffic,
         which they would otherwise assume just means endlessly retrying the same call. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 160" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Circuit breaker fallback routing">
            <rect x="10" y="20" width="150" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="85" y="50" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Alert Pipeline</text>

            <rect x="300" y="20" width="150" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5" stroke-dasharray="4,3"/>
            <text x="375" y="45" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-secondary)">Primary API</text>
            <text x="375" y="60" text-anchor="middle" font-size="10" fill="var(--text-secondary)">(down)</text>

            <rect x="300" y="100" width="150" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="375" y="130" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Fallback Source</text>

            <rect x="600" y="60" width="150" height="50" rx="8" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="675" y="90" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Pipeline Continues</text>

            <line x1="160" y1="45" x2="295" y2="45" stroke="var(--text-secondary)" stroke-width="1.5" stroke-dasharray="4,3"/>
            <line x1="160" y1="50" x2="230" y2="90" stroke="var(--text-secondary)" stroke-width="1.5"/>
            <line x1="230" y1="90" x2="295" y2="125" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#c1)"/>
            <line x1="450" y1="125" x2="595" y2="90" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#c2)"/>

            <text x="230" y="105" text-anchor="middle" font-size="10" fill="var(--text-secondary)">circuit breaker reroutes</text>

            <defs>
                <marker id="c1" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto"><path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/></marker>
                <marker id="c2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto"><path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/></marker>
            </defs>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> No Fallback Means No Resilience</h4>
        <p>A toolchain with no fallback plan does not degrade gracefully when one API goes down. It simply stops processing alerts until the outage ends.</p>
    </div>
</div>
HTML;

// TASK 7: Practical
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <p>You are the on call integration engineer. A simulated SIEM is pushing live webhook events into your response console, and each one needs to be matched to the correct automated action before the next alert can be handled safely.</p>

    <p>Read each event's payload carefully, choose the matching automated response, and watch the response log confirm each decision. Once every event has been correctly triaged, your automation is considered complete.</p>

    <div class="practical-launch-wrapper">
        <a href="api-driven-security-operations-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Webhook Response Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 8: Conclusion
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>You have now covered the full loop of an API driven security toolchain: authenticating to APIs, parsing the JSON they return, enriching raw alerts with context, triggering automated responses through webhooks, and designing the whole chain so it survives an outage rather than collapsing from one. Together these pieces are what let a security operations center handle a volume of alerts no human team could triage alone.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>API keys and OAuth tokens control which tools are allowed to access security APIs.</li>
        <li>Parsing JSON responses means defensively extracting only the fields that matter.</li>
        <li>Enrichment pipelines add context automatically before an analyst ever opens an alert.</li>
        <li>Webhooks trigger real time automated responses instead of relying on polling.</li>
        <li>Resilient integration design uses timeouts, retries, circuit breakers, and fallbacks to keep the pipeline running through outages.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
