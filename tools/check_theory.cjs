#!/usr/bin/env node
// Browser check of a room theory page served by tools/preview.sh.
//   node tools/check_theory.cjs <theory url> <answers.csv> <out dir>
// Walks every task, submits every answer from the CSV through the real UI, checks the practical
// link, SVG rendering, code colour, text colours and narrow-width overflow, and saves screenshots.
// Prints a JSON report; exit code 1 if any FAIL.
const fs = require('fs');
const path = require('path');
let playwright;
try { playwright = require('playwright'); } catch (e) { playwright = require('/opt/node-tools/node_modules/playwright'); }

const [url, csvPath, outDir] = process.argv.slice(2);
if (!url || !csvPath || !outDir) { console.error('usage: check_theory.cjs <url> <answers.csv> <out dir>'); process.exit(2); }
fs.mkdirSync(outDir, { recursive: true });

const answers = fs.readFileSync(csvPath, 'utf8').split(/\r?\n/).filter(l => l && !l.startsWith('#'))
  .map(l => { const p = l.split(','); return { task: p[0], q: p[1], a: p.slice(2).join(',') }; });
const report = { url, fail: [], warn: [], info: {} };
const fail = (m) => report.fail.push(m);
const warn = (m) => report.warn.push(m);
const IGNORE = /fonts\.(googleapis|gstatic)|cdnjs\.cloudflare|favicon/;

(async () => {
  const browser = await playwright.chromium.launch();
  const ctx = await browser.newContext({ viewport: { width: 1366, height: 900 } });
  const page = await ctx.newPage();
  const errors = [];
  page.on('pageerror', e => errors.push('pageerror: ' + e.message));
  page.on('console', m => { if (m.type() === 'error' && !IGNORE.test(m.text()) && !/Failed to load resource/.test(m.text())) errors.push('console: ' + m.text()); });
  page.on('requestfailed', r => { if (!IGNORE.test(r.url())) errors.push('request failed: ' + r.url()); });
  page.on('response', r => { if (r.status() >= 400 && !IGNORE.test(r.url())) errors.push(`HTTP ${r.status()}: ${r.url()}`); });
  await page.goto(url, { waitUntil: 'networkidle' }).catch(() => page.goto(url));

  const tasks = await page.$$eval('.task-nav-item', els => els.map(e => e.getAttribute('data-task')));
  report.info.tasks = tasks.length;
  const colours = {};
  for (const t of tasks) {
    await page.click(`.task-nav-item[data-task="${t}"]`);
    await page.waitForTimeout(150);
    const sel = `#${t}Content`;
    const res = await page.$eval(sel, (root) => {
      const out = { svgs: [], code: [], colours: {}, links: [] };
      root.querySelectorAll('svg').forEach((s, i) => {
        const r = s.getBoundingClientRect();
        out.svgs.push({ i, w: Math.round(r.width), h: Math.round(r.height), overflowX: r.right > root.getBoundingClientRect().right + 2 });
      });
      root.querySelectorAll('code, pre').forEach(c => {
        const col = getComputedStyle(c).color;
        if (!/^rgb\(255, 255, 255\)$/.test(col)) out.code.push({ text: c.textContent.trim().slice(0, 40), colour: col });
      });
      root.querySelectorAll('.task-body p, .task-body li, .task-body td, .task-body span, .task-body strong, .task-body em, .task-body h2, .task-body h3, .task-body h4').forEach(el => {
        if (el.closest('svg, .questions-section, code, pre')) return;
        const own = [...el.childNodes].some(n => n.nodeType === 3 && n.textContent.trim());
        if (!own) return;
        const col = getComputedStyle(el).color;
        out.colours[col] = (out.colours[col] || 0) + 1;
      });
      root.querySelectorAll('a[href]').forEach(a => out.links.push({ href: a.getAttribute('href'), target: a.getAttribute('target'), text: a.textContent.trim().slice(0, 40) }));
      return out;
    });
    for (const s of res.svgs) {
      if (s.w < 20 || s.h < 20) fail(`${t}: SVG #${s.i} renders at ${s.w}x${s.h} (broken or hidden)`);
      if (s.overflowX) warn(`${t}: SVG #${s.i} overflows the content area`);
    }
    for (const c of res.code) warn(`${t}: command/code "${c.text}" renders in ${c.colour}, QA rule says commands are white`);
    for (const [k, v] of Object.entries(res.colours)) colours[k] = (colours[k] || 0) + v;
    for (const l of res.links) {
      if (/^(javascript:|#)/.test(l.href)) continue;
      const abs = new URL(l.href, url).toString();
      if (abs.startsWith(new URL(url).origin)) {
        const r = await page.request.get(abs, { maxRedirects: 0 }).catch(() => null);
        if (!r || r.status() >= 400) fail(`${t}: link "${l.text}" -> ${l.href} returns ${r ? r.status() : 'error'}`);
        if (/practical/.test(l.href) && l.target !== '_blank') warn(`${t}: practical link does not open in a new tab`);
        report.info.practicalLink = report.info.practicalLink || (/practical/.test(l.href) ? l.href : undefined);
      }
    }
    await page.locator(sel).screenshot({ path: path.join(outDir, `theory-${t}.png`) }).catch(() => {});
  }
  report.info.textColours = colours;
  if (Object.keys(colours).length > 4) warn(`content text uses ${Object.keys(colours).length} different colours: ${JSON.stringify(colours)}`);
  if (!report.info.practicalLink) fail('no working link to the practical page found in any task');

  // Wrong answer feedback, then every right answer through the UI.
  const first = answers.find(x => x.q !== 'q0') || answers[0];
  await page.click(`.task-nav-item[data-task="${first.task}"]`);
  await page.fill(`#answer-${first.q}`, 'definitely wrong');
  await page.click(`#question-${first.q} .submit-btn`);
  await page.waitForSelector(`#feedback-${first.q}`, { state: 'visible', timeout: 5000 }).catch(() => {});
  report.info.wrongFeedback = (await page.textContent(`#feedback-${first.q}`).catch(() => '')).trim();
  for (const x of answers) {
    await page.click(`.task-nav-item[data-task="${x.task}"]`);
    const input = page.locator(`#answer-${x.q}`);
    if (!(await input.count())) { fail(`${x.task} ${x.q}: no input on the page for this CSV row`); continue; }
    await input.fill(x.a);
    await page.click(`#question-${x.q} .submit-btn`);
    await page.waitForFunction(q => { const f = document.getElementById('feedback-' + q); return f && f.textContent.trim().length > 0; }, x.q, { timeout: 5000 }).catch(() => {});
    const fb = (await page.textContent(`#feedback-${x.q}`).catch(() => '')).trim();
    if (!/Correct/.test(fb)) fail(`${x.task} ${x.q}: CSV answer "${x.a}" not accepted (feedback "${fb}")`);
  }
  await page.waitForTimeout(1800);
  report.info.completionModal = await page.isVisible('#roomCompletionModal');
  if (!report.info.completionModal) fail('completion modal did not appear after all answers');
  await page.screenshot({ path: path.join(outDir, 'theory-complete.png') });

  // Narrow width.
  for (const vp of [{ width: 820, height: 1000 }, { width: 390, height: 844 }]) {
    const p2 = await ctx.newPage();
    await p2.setViewportSize(vp);
    await p2.goto(url).catch(() => {});
    await p2.waitForTimeout(400);
    for (const t of tasks) {
      await p2.click(`.task-nav-item[data-task="${t}"]`).catch(() => {});
      const over = await p2.evaluate(() => document.documentElement.scrollWidth - window.innerWidth);
      if (over > 2) fail(`${vp.width}px wide: ${t} scrolls sideways by ${over}px (content wider than the screen)`);
    }
    await p2.screenshot({ path: path.join(outDir, `theory-${vp.width}px.png`), fullPage: false });
    await p2.close();
  }
  report.errors = [...new Set(errors)];
  for (const e of report.errors) fail(e);
  await browser.close();
  console.log(JSON.stringify(report, null, 2));
  process.exit(report.fail.length ? 1 : 0);
})().catch(e => { console.error(e); process.exit(2); });
