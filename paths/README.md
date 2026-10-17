# paths/

The two live learning paths, imported from `Platform.zip` (2026-10-17) for side-by-side QA.

| File | What it is |
|---|---|
| `junior-penetration-testing-path.csv` | One row per room in the path design document (9 modules, 48 rooms), plus 6 rooms found in the zip that the design document does not list. Columns: module, room, Present (yes or missing), slug, folder under `Platform Rooms/`, source zip, QA status, QA report. |
| `security-engineer-path.csv` | Same for the Security Engineer Path (10 modules, 57 rooms). |
| `design-docs/` | The path design documents as provided. |

Room files were copied unchanged into `Platform Rooms/<Path>/<Module>/<slug>/`. Rooms whose zip name
did not match a room in the design document are under `Unlisted Rooms (not in path design doc)/`.

Not imported: `Response under Recommendations.rar` (Junior Penetration Testing Path) is password protected.

Rooms in the design documents with no files in the zip (`Present = missing`):
- Junior Penetration Testing Path (6): Understanding Payloads & Shells, CVE Research & Public Exploits,
  Exploitation in Practice, Linux Privilege Escalation, Windows Privilege Escalation, Maintaining Access & Persistence.
- Security Engineer Path (8): Web Application Firewall Engineering, AWS Security Engineering, Azure Security
  Engineering, Linux OS Hardening, CIS Benchmarks & Security Baselines, Patch Management Engineering,
  NIST & ISO 27001 Technical Controls Implementation, PCI DSS Technical Implementation.
