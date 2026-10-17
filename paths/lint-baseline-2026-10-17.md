# Static baseline of the live paths (2026-10-17)

Output of `tools/lint_room.py` over every imported room, before any fixes. Counts are rooms affected.
This is only the mechanical half of QA; each room still needs a full Path QA audit.

| Defect | Junior Penetration Testing Path (48 rooms) | Security Engineer Path (49 rooms) |
|---|---|---|
| tutorial: no Escape | 48 | 49 |
| flag in plain source | 48 | 49 |
| tutorial: no first-visit flag | 48 | 49 |
| no plain "Not yet." feedback | 48 | 49 |
| flag not sealed | 48 | 49 |
| no auth guard on practical | 48 | 48 |
| CSV header missing | 47 | 49 |
| em dash | 40 | 23 |
| no narrow-width media query | 11 | 13 |
| answer over 3 words | 4 | 6 |
| room id != slug | 6 | 2 |
| Hint button/panel | 2 | 4 |
| storage key | 3 | 3 |
| duplicate answer | 2 | 3 |
| PHP question ids differ from CSV | 2 | 2 |
| count written in words | 3 | 1 |
| CSV q ids not continuous | 1 | 2 |
| CSV q0 not yes | 1 | 1 |
| difficulty label | 2 | 0 |
| file naming | 1 | 0 |
| other | 1 | 0 |

## Per room

| Path | Module | Room | FAIL | WARN | Difficulty |
|---|---|---|---|---|---|
| Junior Penetration Testing Path | Exploitation Fundamentals | introduction-to-exploitation | 8 | 21 | Beginner |
| Junior Penetration Testing Path | Exploitation Fundamentals | metasploit-framework-basics | 8 | 21 | Intermediate |
| Junior Penetration Testing Path | Network Attacks & Exploitation | ftp-telnet-legacy | 7 | 4 | Beginner |
| Junior Penetration Testing Path | Network Attacks & Exploitation | mitm-attacks | 5 | 5 | Intermediate |
| Junior Penetration Testing Path | Network Attacks & Exploitation | network-protocols-pentesters | 8 | 20 | Intermediate |
| Junior Penetration Testing Path | Network Attacks & Exploitation | smb-exploitation-basics | 8 | 6 | Intermediate |
| Junior Penetration Testing Path | Network Attacks & Exploitation | vpn-firewall-evasion | 8 | 8 | Intermediate |
| Junior Penetration Testing Path | Network Attacks & Exploitation | wireless-security-fundamentals | 10 | 8 | Intermediate |
| Junior Penetration Testing Path | Password Attacks | brute-force-credential-spraying | 6 | 6 | Intermediate |
| Junior Penetration Testing Path | Password Attacks | default-leaked-credentials | 8 | 5 | Easy |
| Junior Penetration Testing Path | Password Attacks | hash-types-identification | 9 | 6 | Beginner |
| Junior Penetration Testing Path | Password Attacks | password-attack-fundamentals | 9 | 30 | Intermediate |
| Junior Penetration Testing Path | Password Attacks | wordlist-attacks | 7 | 6 | Beginner |
| Junior Penetration Testing Path | Penetration Testing Fundamentals | legal-ethical-framework | 16 | 10 | Intermediate |
| Junior Penetration Testing Path | Penetration Testing Fundamentals | pentest-methodologies | 14 | 15 | Intermediate |
| Junior Penetration Testing Path | Penetration Testing Fundamentals | pentest-types | 8 | 15 | Easy |
| Junior Penetration Testing Path | Penetration Testing Fundamentals | scoping-roe | 19 | 7 | Intermediate |
| Junior Penetration Testing Path | Penetration Testing Fundamentals | what-is-penetration-testing | 5 | 6 | Beginner |
| Junior Penetration Testing Path | Post-Exploitation & Privilege Escalation | lateral-movement-concepts | 6 | 10 | Intermediate |
| Junior Penetration Testing Path | Post-Exploitation & Privilege Escalation | post-exploitation | 5 | 4 | Intermediate |
| Junior Penetration Testing Path | Reconnaissance & OSINT | google-dorking-osint | 6 | 7 | Beginner |
| Junior Penetration Testing Path | Reconnaissance & OSINT | intro-to-recon | 7 | 8 | Beginner |
| Junior Penetration Testing Path | Reconnaissance & OSINT | osint-people-orgs | 7 | 5 | Intermediate |
| Junior Penetration Testing Path | Reconnaissance & OSINT | shodan-passive-recon | 11 | 5 | Intermediate |
| Junior Penetration Testing Path | Reconnaissance & OSINT | whois-dns-domain-enumeration | 8 | 5 | Beginner |
| Junior Penetration Testing Path | Reporting & Documentation | cvss-scoring | 8 | 9 | Intermediate |
| Junior Penetration Testing Path | Reporting & Documentation | pentest-report-structure | 7 | 5 | Intermediate |
| Junior Penetration Testing Path | Reporting & Documentation | remediation-followup | 7 | 4 | Intermediate |
| Junior Penetration Testing Path | Reporting & Documentation | vulnerability-writeups | 8 | 5 | Beginner |
| Junior Penetration Testing Path | Scanning & Enumeration | introduction-to-scanning | 7 | 6 | Intermediate |
| Junior Penetration Testing Path | Scanning & Enumeration | nmap-fundamentals | 8 | 13 | Intermediate |
| Junior Penetration Testing Path | Scanning & Enumeration | service-version-detection | 8 | 11 | Beginner |
| Junior Penetration Testing Path | Scanning & Enumeration | vulnerability-scanning-concepts | 7 | 6 | Beginner |
| Junior Penetration Testing Path | Scanning & Enumeration | web-app-enumeration | 7 | 5 | Intermediate |
| Junior Penetration Testing Path | Unlisted Rooms (not in path design doc) | network-attacks | 8 | 5 | Intermediate |
| Junior Penetration Testing Path | Unlisted Rooms (not in path design doc) | network-scanning | 5 | 6 | Intermediate |
| Junior Penetration Testing Path | Unlisted Rooms (not in path design doc) | password-attacks | 10 | 28 | Intermediate |
| Junior Penetration Testing Path | Unlisted Rooms (not in path design doc) | reconnaissance | 6 | 6 | Intermediate |
| Junior Penetration Testing Path | Unlisted Rooms (not in path design doc) | sql-injection | 7 | 6 | Intermediate |
| Junior Penetration Testing Path | Unlisted Rooms (not in path design doc) | web-app-exploitation | 7 | 6 | Intermediate |
| Junior Penetration Testing Path | Web Application Penetration Testing | authentication-session-attacks | 10 | 9 | Intermediate |
| Junior Penetration Testing Path | Web Application Penetration Testing | command-injection | 7 | 10 | Intermediate |
| Junior Penetration Testing Path | Web Application Penetration Testing | cross-site-scripting | 7 | 13 | Intermediate |
| Junior Penetration Testing Path | Web Application Penetration Testing | directory-traversal-file-inclusion | 5 | 6 | Intermediate |
| Junior Penetration Testing Path | Web Application Penetration Testing | idor | 7 | 5 | Beginner |
| Junior Penetration Testing Path | Web Application Penetration Testing | sql-injection | 5 | 13 | Intermediate |
| Junior Penetration Testing Path | Web Application Penetration Testing | web-app-architecture | 7 | 4 | Beginner |
| Junior Penetration Testing Path | Web Application Penetration Testing | xxe-ssrf | 7 | 8 | Intermediate |
| Security Engineer Path | Application Security Engineering | api-security-engineering | 6 | 10 | Intermediate |
| Security Engineer Path | Application Security Engineering | container-kubernetes-security | 6 | 7 | Intermediate |
| Security Engineer Path | Application Security Engineering | devsecops-engineering | 7 | 6 | Intermediate |
| Security Engineer Path | Application Security Engineering | secure-code-review | 6 | 2 | Intermediate |
| Security Engineer Path | Application Security Engineering | ssdlc | 5 | 5 | Intermediate |
| Security Engineer Path | Cloud Security Engineering | cloud-iam-privesc | 8 | 6 | Intermediate |
| Security Engineer Path | Cloud Security Engineering | cloud-security-architecture | 5 | 8 | Intermediate |
| Security Engineer Path | Cloud Security Engineering | cloud-workload-protection | 5 | 10 | Intermediate |
| Security Engineer Path | Cloud Security Engineering | iac-security | 7 | 6 | Intermediate |
| Security Engineer Path | Compliance & Security Governance | gdpr-technical-controls | 7 | 5 | Intermediate |
| Security Engineer Path | Compliance & Security Governance | security-audit-compliance-automation | 6 | 4 | Intermediate |
| Security Engineer Path | Compliance & Security Governance | security-metrics-reporting | 8 | 5 | Intermediate |
| Security Engineer Path | Cryptography & Data Protection | applied-cryptography-for-engineers | 9 | 5 | Intermediate |
| Security Engineer Path | Cryptography & Data Protection | digital-signatures-ca-operations | 6 | 9 | Expert |
| Security Engineer Path | Cryptography & Data Protection | encryption-at-rest-in-transit | 8 | 7 | Intermediate |
| Security Engineer Path | Cryptography & Data Protection | key-management-systems | 8 | 5 | Expert |
| Security Engineer Path | Cryptography & Data Protection | tls-ssl-engineering | 5 | 6 | Expert |
| Security Engineer Path | Endpoint & Infrastructure Hardening | edr-deployment-tuning | 6 | 10 | Intermediate |
| Security Engineer Path | Endpoint & Infrastructure Hardening | email-security-engineering | 8 | 7 | Expert |
| Security Engineer Path | Endpoint & Infrastructure Hardening | windows-os-hardening | 6 | 7 | Intermediate |
| Security Engineer Path | Identity & Access Management Engineering | ad-security-engineering | 5 | 9 | Expert |
| Security Engineer Path | Identity & Access Management Engineering | federation-sso-engineering | 8 | 10 | Expert |
| Security Engineer Path | Identity & Access Management Engineering | iam-architecture-design | 5 | 6 | Intermediate |
| Security Engineer Path | Identity & Access Management Engineering | mfa-engineering | 7 | 9 | Intermediate |
| Security Engineer Path | Identity & Access Management Engineering | pki-certificate-management | 5 | 6 | Intermediate |
| Security Engineer Path | Identity & Access Management Engineering | privileged-access-management | 6 | 9 | Intermediate |
| Security Engineer Path | Network Security Engineering | dns-security-engineering | 5 | 29 | Intermediate |
| Security Engineer Path | Network Security Engineering | firewall-architecture-rule-engineering | 5 | 5 | Intermediate |
| Security Engineer Path | Network Security Engineering | ids-ips-engineering | 7 | 8 | Expert |
| Security Engineer Path | Network Security Engineering | network-access-control | 6 | 13 | Intermediate |
| Security Engineer Path | Network Security Engineering | network-segmentation-dmz | 6 | 6 | Intermediate |
| Security Engineer Path | Network Security Engineering | vpn-architecture-implementation | 5 | 9 | Intermediate |
| Security Engineer Path | Network Security Engineering | zero-trust-architecture | 5 | 8 | Intermediate |
| Security Engineer Path | Security Automation & Orchestration | api-driven-security-operations | 5 | 11 | Intermediate |
| Security Engineer Path | Security Automation & Orchestration | python-security-engineering | 7 | 5 | Intermediate |
| Security Engineer Path | Security Automation & Orchestration | security-automation-fundamentals | 7 | 5 | Intermediate |
| Security Engineer Path | Security Automation & Orchestration | siem-detection-engineering | 7 | 12 | Intermediate |
| Security Engineer Path | Security Automation & Orchestration | soar-platform-engineering | 12 | 6 | Intermediate |
| Security Engineer Path | Security Engineering Foundations | risk-driven-security-engineering | 5 | 5 | Intermediate |
| Security Engineer Path | Security Engineering Foundations | security-architecture-frameworks | 8 | 10 | Expert |
| Security Engineer Path | Security Engineering Foundations | security-controls-mapping | 8 | 12 | Intermediate |
| Security Engineer Path | Security Engineering Foundations | security-design-patterns | 6 | 6 | Intermediate |
| Security Engineer Path | Security Engineering Foundations | security-engineering-principles | 10 | 6 | Intermediate |
| Security Engineer Path | Security Engineering Foundations | threat-modelling | 8 | 8 | Intermediate |
| Security Engineer Path | Vulnerability Management | patch-management-remediation-workflows | 7 | 7 | Intermediate |
| Security Engineer Path | Vulnerability Management | pentest-purple-teaming | 7 | 12 | Intermediate |
| Security Engineer Path | Vulnerability Management | risk-scoring-prioritisation | 7 | 7 | Intermediate |
| Security Engineer Path | Vulnerability Management | vulnerability-management-programme | 7 | 9 | Intermediate |
| Security Engineer Path | Vulnerability Management | vulnerability-scanning-architecture | 5 | 7 | Intermediate |
