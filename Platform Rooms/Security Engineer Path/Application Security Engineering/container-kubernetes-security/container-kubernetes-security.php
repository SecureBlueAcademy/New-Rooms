<?php
// container-kubernetes-security.php
// Room data file. Rendered by ../../includes/room-engine.php

// ========================
// 1. ROOM CONFIGURATION
// ========================
$room_config = [
    'id'              => 'container-kubernetes-security',
    'title'           => 'Container & Kubernetes Security Engineering',
    'description'     => 'Secure containerised workloads from image build through runtime: hardening, RBAC, network policy, Pod Security Standards, secrets, and threat detection.',
    'icon'            => 'fas fa-boxes-stacked',
    'banner'          => '../../assets/banner-tcpip.png',
    'difficulty'      => 'Intermediate',
    'estimated_time'  => '60 minutes',
    'prerequisites'   => ['Basic Docker knowledge', 'Basic Kubernetes concepts (pods, deployments)'],
    'learning_objectives' => [
        'Identify security risks introduced at container image build time and how to reduce them',
        'Configure a container to run as non-root with a read-only filesystem',
        'Design least-privilege RBAC roles and bindings for Kubernetes identities',
        'Apply NetworkPolicies to segment pod-to-pod traffic',
        'Explain the three Pod Security Standard profiles and how they are enforced',
        'Describe secure secrets handling and runtime threat detection with tools like Falco',
    ],
];

// ========================
// 2. ANSWERS FILE PATH
// ========================
$answers_file = __DIR__ . '/container-kubernetes-security-answers.csv';

// ========================
// 3. SIDEBAR TASK LIST
// ========================
$room_tasks = [
    ['id' => 'task1', 'title' => 'Introduction'],
    ['id' => 'task2', 'title' => 'Container Image Security'],
    ['id' => 'task3', 'title' => 'Non-Root & Read-Only Hardening'],
    ['id' => 'task4', 'title' => 'Kubernetes RBAC'],
    ['id' => 'task5', 'title' => 'Network Policies'],
    ['id' => 'task6', 'title' => 'Pod Security Standards'],
    ['id' => 'task7', 'title' => 'Secrets & Runtime Detection'],
    ['id' => 'task8', 'title' => 'Practical'],
    ['id' => 'task9', 'title' => 'Conclusion'],
];

// ========================
// 4. JAVASCRIPT CONFIG
// ========================
$js_config = [
    'storage_key'          => 'container_kubernetes_security_progress',
    'instagram_takeaways'  => [
        '✓ Minimal base images and CI/CD image scanning',
        '✓ Non-root containers with read-only filesystems',
        '✓ Kubernetes RBAC and least-privilege design',
        '✓ NetworkPolicies, Pod Security Standards, and Falco',
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
        ['id' => 'q1', 'text' => 'What type of base image contains no shell, package manager, or OS utilities?'],
        ['id' => 'q2', 'text' => 'What is the general term for scanning container images for known CVEs before deployment?'],
    ],
    'task3' => [
        ['id' => 'q3', 'text' => 'What security context field, when set to true, ensures a container does not run as root?'],
        ['id' => 'q4', 'text' => 'What security context field prevents a container from writing to its own filesystem at runtime?'],
    ],
    'task4' => [
        ['id' => 'q5', 'text' => 'What Kubernetes object defines a set of permissions scoped to a single namespace?'],
        ['id' => 'q6', 'text' => 'What security principle states identities should be granted only the access they need to perform their function?'],
    ],
    'task5' => [
        ['id' => 'q7', 'text' => 'By default, is traffic between pods in a Kubernetes cluster allowed or denied without a NetworkPolicy?'],
        ['id' => 'q8', 'text' => 'What term describes a NetworkPolicy that blocks all traffic until specific rules permit it?'],
    ],
    'task6' => [
        ['id' => 'q9',  'text' => 'What is the most restrictive of the three built-in Pod Security Standard profiles?'],
        ['id' => 'q10', 'text' => 'What Kubernetes object is labeled to enforce a Pod Security Standard on its contents?'],
    ],
    'task7' => [
        ['id' => 'q11', 'text' => 'What is the name of the widely used open source tool for runtime threat detection via syscall monitoring in containers?'],
        ['id' => 'q12', 'text' => 'What Kubernetes object should be used to store sensitive values instead of plaintext environment variables?'],
    ],
    'task8' => [
        ['id' => 'q13', 'text' => 'Enter the flag revealed by the Pod Compliance Console.'],
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
    <p>Container and Kubernetes security engineering protects workloads that no longer live on a single stable server but move constantly between build pipelines, registries, and clusters. Traditional perimeter defenses fall short when a workload can be rescheduled to a new node in seconds and a flaw in a base image can be replicated across hundreds of running pods before anyone notices.</p>

    <p>In this room you will learn how to secure a containerised workload across its full lifecycle: hardening the image before it ships, restricting what the runtime process can do, controlling access with Kubernetes RBAC, segmenting network traffic, enforcing Pod Security Standards, and detecting threats in real time. A hands-on practical is included where you will bring a non-compliant pod specification into compliance.</p>

    <h3>Learning Objectives</h3>
    <ul>
        <li>Identify security risks introduced at container image build time and how to reduce them.</li>
        <li>Configure a container to run as non-root with a read-only filesystem.</li>
        <li>Design least-privilege RBAC roles and bindings for Kubernetes identities.</li>
        <li>Apply NetworkPolicies to segment pod-to-pod traffic.</li>
        <li>Explain the three Pod Security Standard profiles and how they are enforced.</li>
        <li>Describe secure secrets handling and runtime threat detection with tools like Falco.</li>
    </ul>
</div>
HTML;

// TASK 2: Container Image Security
$task_contents[2] = <<<'HTML'
<div class="content-block">
    <h2>Security Starts Before the Container Runs</h2>

    <p>Every container begins as an image, and every flaw baked into that image travels with it into every environment it is deployed to. A bloated image built from a full operating system carries package managers, shells, and libraries the application will never use, and each of those is a potential entry point for an attacker who gains a foothold.</p>

    <p>Minimal images reduce this exposure. A <strong>distroless</strong> image ships only the application and its runtime dependencies, with no shell, no package manager, and no OS utilities at all. If an attacker cannot get a shell, many post-exploitation techniques simply do not work.</p>

    <h3>Multi-Stage Builds</h3>
    <p>A multi-stage Dockerfile uses one stage to compile or build the application, with all its build tools and source code, and a separate final stage that copies only the compiled artifact into a minimal base image. The build toolchain never ships to production.</p>

    <!-- SVG: multi-stage build diagram
         Teaching purpose: show the learner that only the runtime artifact reaches production,
         which they would otherwise assume includes the full build toolchain. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 160" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Multi-stage build diagram">
            <rect x="10" y="30" width="330" height="100" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="175" y="55" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Builder Stage</text>
            <text x="175" y="78" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Compiler, source code,</text>
            <text x="175" y="94" text-anchor="middle" font-size="11" fill="var(--text-secondary)">build tools, dependencies</text>
            <line x1="345" y1="80" x2="405" y2="80" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr2)"/>
            <text x="375" y="70" text-anchor="middle" font-size="10" fill="var(--text-secondary)">copy artifact</text>
            <defs>
                <marker id="arr2" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <rect x="415" y="30" width="330" height="100" rx="10" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <text x="580" y="55" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Final Image</text>
            <text x="580" y="78" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Compiled binary only,</text>
            <text x="580" y="94" text-anchor="middle" font-size="11" fill="var(--text-secondary)">no compiler, no shell</text>
        </svg>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Image Scanning in CI/CD</h4>
        <p>Image scanning tools inspect layers against known CVE databases before an image is allowed into a registry. A well-configured pipeline fails the build automatically when a critical severity vulnerability is found, rather than relying on someone to review a report later.</p>
    </div>

    <h3>Comparing Base Images</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Base Image</th>
                <th>Size</th>
                <th>Attack Surface</th>
                <th>Use Case</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Full OS (e.g. Ubuntu)</td>
                <td>Large</td>
                <td>High</td>
                <td>Debugging, legacy compatibility</td>
            </tr>
            <tr>
                <td>Slim</td>
                <td>Medium</td>
                <td>Medium</td>
                <td>General purpose apps needing some OS tools</td>
            </tr>
            <tr>
                <td>Alpine</td>
                <td>Small</td>
                <td>Low</td>
                <td>Lightweight apps, still has a shell</td>
            </tr>
            <tr>
                <td>Distroless</td>
                <td>Smallest</td>
                <td>Lowest</td>
                <td>Production services with no interactive need</td>
            </tr>
        </tbody>
    </table>
</div>
HTML;

// TASK 3: Non-Root & Read-Only Runtime Hardening
$task_contents[3] = <<<'HTML'
<div class="content-block">
    <h2>Limiting What a Compromised Process Can Do</h2>

    <p>Root inside a container is still root on the underlying kernel's process table. If an attacker escapes application-level restrictions, running as root hands them a far wider set of options than running as an unprivileged user would. Root in a container behaves like a master key that opens far more doors than the job requires.</p>

    <p>Kubernetes lets you enforce a non-root identity directly in the pod spec with the <strong>runAsNonRoot</strong> field, and pair it with a specific <strong>runAsUser</strong> ID so the container never even attempts to start as root.</p>

    <h3>Read-Only Filesystems and Capabilities</h3>
    <p>Setting <strong>readOnlyRootFilesystem</strong> to true prevents a process from writing anywhere in its own container filesystem, which blocks many forms of malware that need to drop files or modify binaries to persist. Combined with dropping all Linux capabilities and re-adding only what is strictly needed, this shrinks the actions available to an attacker who does get code execution.</p>

    <!-- SVG: root vs non-root container reach
         Teaching purpose: show the learner that isolation is not automatic just because a process
         runs in a container, which they would otherwise assume regardless of the user it runs as. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 170" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Root versus non-root container reach">
            <rect x="10" y="20" width="350" height="130" rx="10" fill="var(--surface)" stroke="var(--error)" stroke-width="1.5"/>
            <text x="185" y="45" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Root Container Process</text>
            <text x="185" y="70" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Can write to filesystem</text>
            <text x="185" y="90" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Can attempt kernel-level actions</text>
            <text x="185" y="110" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Wider path toward host access</text>
            <rect x="400" y="20" width="350" height="130" rx="10" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <text x="575" y="45" text-anchor="middle" font-size="14" font-weight="600" fill="var(--text-primary)">Non-Root, Read-Only Process</text>
            <text x="575" y="70" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Cannot write to filesystem</text>
            <text x="575" y="90" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Capabilities dropped</text>
            <text x="575" y="110" text-anchor="middle" font-size="11" fill="var(--text-secondary)">Far fewer actions available</text>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Dangerous Capabilities</h4>
        <p>Capabilities such as NET_ADMIN and SYS_ADMIN grant near-root power even to a non-root user. Drop all capabilities by default and add back only the specific ones a workload genuinely needs.</p>
    </div>
</div>
HTML;

// TASK 4: Kubernetes RBAC
$task_contents[4] = <<<'HTML'
<div class="content-block">
    <h2>Controlling Who Can Do What in the Cluster</h2>

    <p>Kubernetes RBAC (Role-Based Access Control) determines which identities, whether human users or service accounts, are allowed to perform which actions on which resources. Without deliberate design, it is easy to grant far more access than an identity actually needs.</p>

    <p>Think of RBAC like a hotel keycard system. A guest's keycard opens their own room and shared spaces like the gym, but not the manager's office or the server room. A master key exists, but very few people should ever be handed one.</p>

    <h3>Roles and Bindings</h3>
    <p>A <strong>Role</strong> defines a set of permissions, verbs like get, list, or delete on resources like pods or secrets, scoped to a single namespace. A <strong>ClusterRole</strong> defines the same kind of permissions but can be applied cluster-wide. Neither grants anything on its own until it is connected to an identity through a binding.</p>

    <!-- SVG: Role, RoleBinding, ServiceAccount relationship
         Teaching purpose: show the learner how the three objects connect to grant access,
         which they would otherwise treat as one flat permission list. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 140" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Role RoleBinding ServiceAccount relationship">
            <rect x="10" y="35" width="200" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="110" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Role</text>
            <text x="110" y="85" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Defines permissions</text>
            <line x1="215" y1="70" x2="280" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <rect x="285" y="35" width="200" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="385" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">RoleBinding</text>
            <text x="385" y="85" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Connects Role to identity</text>
            <line x1="490" y1="70" x2="555" y2="70" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr3)"/>
            <defs>
                <marker id="arr3" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <rect x="560" y="35" width="190" height="70" rx="10" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <text x="655" y="65" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">ServiceAccount</text>
            <text x="655" y="85" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Receives the access</text>
        </svg>
    </div>

    <h3>Object Comparison</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Object</th>
                <th>Scope</th>
                <th>Purpose</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Role</td>
                <td>Single namespace</td>
                <td>Defines a set of permissions</td>
            </tr>
            <tr>
                <td>ClusterRole</td>
                <td>Cluster-wide</td>
                <td>Defines permissions usable across namespaces</td>
            </tr>
            <tr>
                <td>RoleBinding</td>
                <td>Single namespace</td>
                <td>Grants a Role or ClusterRole to an identity in one namespace</td>
            </tr>
            <tr>
                <td>ClusterRoleBinding</td>
                <td>Cluster-wide</td>
                <td>Grants a ClusterRole to an identity across the whole cluster</td>
            </tr>
        </tbody>
    </table>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Avoid Wildcards</h4>
        <p>A Role that grants verbs like <strong>*</strong> on resources like <strong>*</strong> is the equivalent of handing out a master key. Always list the specific verbs and resources an identity genuinely needs, following the principle of least privilege.</p>
    </div>
</div>
HTML;

// TASK 5: Network Policies
$task_contents[5] = <<<'HTML'
<div class="content-block">
    <h2>Segmenting Traffic Inside the Cluster</h2>

    <p>Kubernetes networking is flat by default. Any pod can reach any other pod across the entire cluster unless something is put in place to restrict it, regardless of which namespace or team each pod belongs to.</p>

    <p>This is similar to an office building where every floor connects freely to every other floor. It works fine until one compromised floor gives an intruder a path to every other floor in the building. Segmenting access at each floor limits how far a single breach can spread.</p>

    <h3>NetworkPolicy Basics</h3>
    <p>A NetworkPolicy selects pods using labels and then defines allowed ingress and egress traffic using podSelector or namespaceSelector rules. Any traffic not explicitly allowed by a matching policy is dropped once at least one policy applies to a pod.</p>

    <!-- SVG: pods before and after NetworkPolicy
         Teaching purpose: show the learner that pod networking is open by default,
         which they would otherwise assume is isolated per pod. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 170" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Pods before and after NetworkPolicy">
            <text x="185" y="20" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Before: Flat Network</text>
            <circle cx="110" cy="80" r="30" fill="var(--surface)" stroke="var(--error)" stroke-width="1.5"/>
            <circle cx="185" cy="120" r="30" fill="var(--surface)" stroke="var(--error)" stroke-width="1.5"/>
            <circle cx="260" cy="80" r="30" fill="var(--surface)" stroke="var(--error)" stroke-width="1.5"/>
            <line x1="130" y1="95" x2="165" y2="110" stroke="var(--error)" stroke-width="1.5"/>
            <line x1="205" y1="110" x2="240" y2="95" stroke="var(--error)" stroke-width="1.5"/>
            <line x1="135" y1="80" x2="235" y2="80" stroke="var(--error)" stroke-width="1.5"/>
            <text x="575" y="20" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">After: NetworkPolicy Applied</text>
            <circle cx="500" cy="80" r="30" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <circle cx="575" cy="120" r="30" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <circle cx="650" cy="80" r="30" fill="var(--surface)" stroke="var(--success)" stroke-width="1.5"/>
            <line x1="520" y1="95" x2="555" y2="110" stroke="var(--success)" stroke-width="1.5"/>
        </svg>
    </div>

    <div class="success-box">
        <h4><i class="fas fa-lightbulb"></i> Start With Default Deny</h4>
        <p>Apply a default-deny-all NetworkPolicy to a namespace first, then add specific allow rules for the traffic each workload genuinely needs. This avoids accidentally leaving gaps open that a broader policy would have covered.</p>
    </div>
</div>
HTML;

// TASK 6: Pod Security Standards
$task_contents[6] = <<<'HTML'
<div class="content-block">
    <h2>Enforcing a Baseline Across the Cluster</h2>

    <p>Individual pod configuration choices are easy to get wrong at scale. Pod Security Standards give a cluster administrator a way to enforce a consistent security baseline across every pod in a namespace, rather than relying on each team to configure every field correctly by hand.</p>

    <p>Think of the three profiles as security tiers in a building. A public lobby allows almost anyone to pass through, a general office floor has some access control, and a secure vault floor allows almost nothing without explicit approval.</p>

    <h3>The Three Profiles</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th>Profile</th>
                <th>Description</th>
                <th>Example Restriction</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Privileged</td>
                <td>Unrestricted, allows known privilege escalations</td>
                <td>Privileged containers are permitted</td>
            </tr>
            <tr>
                <td>Baseline</td>
                <td>Prevents known privilege escalations</td>
                <td>Privileged containers are blocked</td>
            </tr>
            <tr>
                <td>Restricted</td>
                <td>Heavily restricted, following current hardening best practice</td>
                <td>Requires runAsNonRoot and a seccomp profile</td>
            </tr>
        </tbody>
    </table>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Enforcement via Namespace Labels</h4>
        <p>Pod Security Standards are enforced by applying labels to a Namespace object itself, using enforce, audit, or warn modes. There is no separate controller to install, since this replaced the older PodSecurityPolicy mechanism.</p>
    </div>
</div>
HTML;

// TASK 7: Secrets Management & Runtime Detection (Falco)
$task_contents[7] = <<<'HTML'
<div class="content-block">
    <h2>Protecting Secrets and Watching for Threats Live</h2>

    <p>Even a perfectly hardened image and a tightly scoped RBAC setup can be undone by a plaintext password sitting in an environment variable or committed alongside the application code. Secrets need handling that is deliberately separate from ordinary configuration.</p>

    <p>Storing a credential in a Kubernetes <strong>Secret</strong> object, ideally backed by an external secrets store and encrypted at rest, is the equivalent of using a safe deposit box instead of leaving the password on a sticky note taped to the front of the safe.</p>

    <h3>Runtime Detection With Falco</h3>
    <p>Hardening reduces what a workload can do, but it does not guarantee nothing will ever go wrong. Falco monitors syscalls made by running containers and raises alerts on suspicious behavior such as an unexpected shell being spawned inside a container or a write to a sensitive system path. It acts like a guard watching live camera feeds rather than only checking identification at the door.</p>

    <!-- SVG: syscalls to Falco engine to alert pipeline
         Teaching purpose: show the learner that detection is continuous at runtime,
         which they would otherwise assume ends once the pod is deployed. -->
    <div style="margin: 20px 0;">
        <svg viewBox="0 0 760 130" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Syscalls to Falco engine to alert pipeline">
            <rect x="10" y="30" width="200" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="110" y="60" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Container Syscalls</text>
            <text x="110" y="80" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Live process activity</text>
            <line x1="215" y1="65" x2="280" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <defs>
                <marker id="arr4" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="var(--text-secondary)"/>
                </marker>
            </defs>
            <rect x="285" y="30" width="200" height="70" rx="10" fill="var(--surface)" stroke="var(--border)" stroke-width="1.5"/>
            <text x="385" y="60" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Falco Rules Engine</text>
            <text x="385" y="80" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Matches suspicious patterns</text>
            <line x1="490" y1="65" x2="555" y2="65" stroke="var(--text-secondary)" stroke-width="1.5" marker-end="url(#arr4)"/>
            <rect x="560" y="30" width="190" height="70" rx="10" fill="var(--surface)" stroke="var(--error)" stroke-width="1.5"/>
            <text x="655" y="60" text-anchor="middle" font-size="13" font-weight="600" fill="var(--text-primary)">Alert</text>
            <text x="655" y="80" text-anchor="middle" font-size="10" fill="var(--text-secondary)">Sent to security team</text>
        </svg>
    </div>

    <div class="warning-box">
        <h4><i class="fas fa-triangle-exclamation"></i> Never Hardcode Secrets</h4>
        <p>Placing credentials directly in environment variables or baking them into an image means anyone with read access to the pod spec or image layers can read them. Use a Secret object or an external secrets manager instead.</p>
    </div>
</div>
HTML;

// TASK 8: Practical
$task_contents[8] = <<<'HTML'
<div class="content-block">
    <p>A pod specification for the <strong>payments-api</strong> workload is awaiting admission review, and it currently fails every check in the compliance panel. Your job is to walk through each failing check and select the correct fix so the pod meets the Restricted Pod Security Standard.</p>

    <p>Open the console below, review each check on the right, and choose the fix that actually closes the gap rather than one that merely changes the value. The pod is admitted only once all six checks pass.</p>

    <div class="practical-launch-wrapper">
        <a href="container-kubernetes-security-practical.php" target="_blank" class="practical-launch-btn">
            <span class="launch-icon">⚡</span>
            <span class="launch-text">Launch Pod Compliance Console</span>
            <span class="launch-arrow">→</span>
        </a>
        <p class="launch-note">Opens in a new tab. Complete the challenge and return here to enter the flag.</p>
    </div>
</div>
HTML;

// TASK 9: Conclusion
$task_contents[9] = <<<'HTML'
<div class="content-block">
    <p>You have now walked the full lifecycle of container and Kubernetes security: reducing risk before an image ever ships, restricting what a running container can do, controlling access with RBAC, segmenting network traffic, enforcing a consistent baseline with Pod Security Standards, and watching for threats at runtime with tools like Falco. None of these controls alone would be enough, but together they form a layered defense that holds even when one layer is bypassed.</p>

    <h3>Key Takeaways</h3>
    <ul>
        <li>Minimal, distroless images and CI/CD scanning reduce what ships to production.</li>
        <li>Running as non-root with a read-only filesystem limits what a compromised container can do.</li>
        <li>RBAC should grant only the specific verbs and resources an identity needs, never wildcards.</li>
        <li>Kubernetes networking is flat by default, so NetworkPolicies must be applied deliberately.</li>
        <li>Pod Security Standards enforce a consistent baseline across every pod in a namespace.</li>
        <li>Secrets belong in dedicated secret stores, and runtime detection catches what hardening misses.</li>
    </ul>
</div>
HTML;

// ============================================================
// END OF DATA
// ============================================================
define('CYBRIXEN_ROOM_ENGINE', true);
require_once '../../includes/room-engine.php';
