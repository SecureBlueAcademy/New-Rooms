# Example output layout (completed rooms)

The completed rooms live in `/workspace/rooms-project/output/` on the build box. Their PHP files are 10 to 160 KB each, so they are not copied into this kit. Only the two small answer CSVs are copied here. All files listed below are real.

## Challenge example: `zerologon-domain-takeover-investigation/` (NTI-M01-R02)
| File | Size | Purpose |
|---|---|---|
| `zerologon-domain-takeover-investigation.php` | 11,877 B | Theory page. 3 tasks: Introduction, Domain Takeover Investigation (q1 to q9, q9 = flag), Conclusion. |
| `zerologon-domain-takeover-investigation-practical.php` | 60,592 B | Multi-tab log analyser. Tabs: Case Brief, dce_rpc.log, conn.log, netlogon.log, Security/System, Patch Inventory, AD Path Graph, Console. Filter bars per tab. Sealed flag. |
| `zerologon-domain-takeover-investigation-answers.csv` | 289 B | Copied here. 11 rows, q0 to q10. Flag CBX{reset_machineaccount}. |

## Learning example: `linux-containment-eradication-and-recovery/` (LIR-M03-R01)
| File | Size | Purpose |
|---|---|---|
| `linux-containment-eradication-and-recovery.php` | 18,684 B | Theory page. 7 tasks: Introduction, Containment Options, Containment Order and Evidence Preservation, Eradication, Recovery and Monitoring, Practical, Conclusion. |
| `linux-containment-eradication-and-recovery-practical.php` | 40,573 B | Containment Simulator: inject feed, host status board, action card deck, decision log, Reset, sealed flag. |
| `linux-containment-eradication-and-recovery-answers.csv` | 365 B | Copied here. 16 rows, q0 to q15. Flag CBX{block_c2_egress}. |

Its packet is `LIR-M03-R01.packet.txt` in this folder, so you can compare packet and output side by side.

## Caution about older outputs
Several earlier practicals in `output/` show counters in wrong-answer feedback (for example "Not yet. 2 of 3 decisions are right."). That pattern is **no longer allowed**. Current QA requires plain "Not yet." with no counters, per-field marks or Hint buttons (see `03-docs/04-room-qa.md`). Use these outputs for structure, not for feedback wording.

## Other folders in output/
23 more single-room folders (WIR, LIR and NTI rooms) plus zip bundles (WIR-M01-*.zip). Each folder holds exactly the same 3 files.
