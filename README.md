# New-Rooms

Cybrixen room production: planning, building, QA and storage of platform rooms, run by a team of
Claude agents following the Room Creation Kit.

- **How the pipeline works:** [`CLAUDE.md`](CLAUDE.md) (roles, flows, layout, house rules, tools)
- **Agents:** [`.claude/agents/`](.claude/agents) (room-planner, room-creator, room-qa, path-qa, room-fixer)
- **Plan:** [`plan/master_plan.csv`](plan/master_plan.csv) and pipeline status in [`plan/status.csv`](plan/status.csv)
- **Live paths under QA:** [`paths/`](paths) manifests for the Junior Penetration Testing Path and the Security Engineer Path
- **Finished rooms:** [`Platform Rooms/`](Platform%20Rooms) as `Track / Module / room-slug / 3 files`
- **Work in progress and reports:** [`pipeline/`](pipeline) (packets, builds, QA reports, audits, fix briefs, handoff log)

## Agent team
```
                 Content Engineer (orchestrator)
                 |            |               |
          Room Planner   Creator 1 (main)   QA lead
                 ^            |               |
                 |            v               +-- Path QA
                 |        new rooms               |  audits the two live paths side by side
                 +--------- fix briefs <----------+
                              |
                              v
                         Creator 2 (room-fixer): fixes live rooms in place
```

## Quick start for a reviewer
```bash
tools/preview.sh "Platform Rooms/<Track>/<Module>/<slug>"     # prints local URLs
python3 tools/lint_room.py "Platform Rooms/<Track>/<Module>/<slug>"
```
