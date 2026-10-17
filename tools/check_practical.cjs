#!/usr/bin/env node
// Browser check of a practical page served by tools/preview.sh.
//   node tools/check_practical.cjs <practical url> <out dir> [--flag CBX{...}] [--spec solve.json]
//
// Generic checks: auth guard, plain flag in served source, tutorial (opens on first visit, page
// behind it cannot scroll, Next/Skip buttons on screen and not covered, spotlight screenshots per
// step, Escape closes, does not reopen after reload), narrow-width overflow, JS errors.
//
// --spec runs a room-specific solve and trap script (written by the Creator, reviewed by QA):
// {
//   "solve":  { "steps": [STEP...], "expectText": "CBX{...}" },
//   "traps":  [ { "name": "reboot first", "steps": [STEP...] } ],   // flag must stay hidden
//   "reset":  { "steps": [STEP...], "expectHidden": "CBX{...}" }     // after a solve
// }
// STEP = {"click": sel} | {"fill": sel, "value": v} | {"select": sel, "value": v} | {"press": key}
//      | {"drag": sel, "to": sel} | {"eval": "js expression"} | {"wait": ms}
// The page is loaded with the tutorial dismissed (Escape) before steps run.
const fs = require('fs');
const path = require('path');
let playwright;
try { playwright = require('playwright'); } catch (e) { playwright = require('/opt/node-tools/node_modules/playwright'); }

const argv = process.argv.slice(2);
const [url, outDir] = argv;
const opt = (k) => { const i = argv.indexOf(k); return i > -1 ? argv[i + 1] : null; };
const flag = opt('--flag');
const spec = opt('--spec') ? JSON.parse(fs.readFileSync(opt('--spec'), 'utf8')) : null;
if (!url || !outDir) { console.error('usage: check_practical.cjs <url> <out dir> [--flag F] [--spec S]'); process.exit(2); }
fs.mkdirSync(outDir, { recursive: true });
const report = { url, fail: [], warn: [], info: {} };
const fail = (m) => report.fail.push(m);
const warn = (m) => report.warn.push(m);
const IGNORE = /fonts\.(googleapis|gstatic)|cdnjs\.cloudflare|favicon|Failed to load resource/;

// Finds the visible tutorial: any visible element whose id/class mentions tutorial, tour, onboard,
// spotlight, tooltip or coach (fixed-position ones preferred), plus its Next/Skip/Close buttons.
const findTutorial = () => {
  const vis = (el) => { const s = getComputedStyle(el); const r = el.getBoundingClientRect(); return s.display !== 'none' && s.visibility !== 'hidden' && +s.opacity > 0.05 && r.width > 0 && r.height > 0; };
  const named = [...document.querySelectorAll(['tutorial', 'tour', 'onboard', 'spotlight', 'tooltip', 'coach'].map(k => `[id*="${k}" i],[class*="${k}" i]`).join(','))]
    .filter(el => vis(el) && !/^(button|a)$/i.test(el.tagName) && !/view-tutorial|tutorial-btn|open-tutorial/i.test(el.id + ' ' + el.className));
  const fixed = named.filter(el => getComputedStyle(el).position === 'fixed');
  const root = fixed[0] || named[0];
  if (!root) return null;
  const btns = [...document.querySelectorAll('button, a, [role="button"]')].filter(b => vis(b) && /\b(next|skip|finish|done|got it|close|start|back|prev)/i.test(b.textContent) && (named.some(n => n.contains(b)) || getComputedStyle(b).position === 'fixed'));
  return {
    id: root.id, cls: String(root.className).slice(0, 60),
    buttons: btns.map(b => {
      const r = b.getBoundingClientRect();
      const cx = r.left + r.width / 2, cy = r.top + r.height / 2;
      const top = document.elementFromPoint(Math.min(Math.max(cx, 0), innerWidth - 1), Math.min(Math.max(cy, 0), innerHeight - 1));
      return { text: b.textContent.trim().slice(0, 20), inView: r.left >= 0 && r.top >= 0 && r.right <= innerWidth && r.bottom <= innerHeight, covered: !(top && (b === top || b.contains(top))) };
    }),
  };
};

async function steps(page, list) {
  for (const s of list || []) {
    if (s.click) await page.click(s.click);
    else if (s.fill) await page.fill(s.fill, String(s.value));
    else if (s.select) await page.selectOption(s.select, String(s.value));
    else if (s.press) await page.keyboard.press(s.press);
    else if (s.drag) await page.dragAndDrop(s.drag, s.to);
    else if (s.eval) await page.evaluate(s.eval);
    else if (s.wait) await page.waitForTimeout(s.wait);
    await page.waitForTimeout(60);
  }
}

async function freshPage(browser, vp) {
  const ctx = await browser.newContext({ viewport: vp });
  const page = await ctx.newPage();
  const errors = [];
  page.on('pageerror', e => errors.push('pageerror: ' + e.message));
  page.on('console', m => { if (m.type() === 'error' && !IGNORE.test(m.text())) errors.push('console: ' + m.text()); });
  page.on('response', r => { if (r.status() >= 400 && !IGNORE.test(r.url())) errors.push(`HTTP ${r.status()}: ${r.url()}`); });
  await page.goto(url, { waitUntil: 'networkidle' }).catch(() => page.goto(url));
  await page.waitForTimeout(700);
  return { ctx, page, errors };
}

(async () => {
  const browser = await playwright.chromium.launch();
  const allErrors = [];

  // 1. Auth guard and source.
  const anon = await browser.newContext();
  await anon.addCookies([{ name: 'preview_logged_out', value: '1', url }]);
  const ar = await anon.request.get(url, { maxRedirects: 0 });
  report.info.loggedOutStatus = ar.status();
  if (ar.status() === 200) fail('practical opens without login (expected a redirect to the login page)');
  await anon.close();
  const src = await (await (await browser.newContext()).request.get(url)).text();
  if (flag && src.includes(flag)) fail(`plain flag ${flag} is in the served page source`);
  if (flag && src.includes(flag.slice(4, -1))) fail(`flag body "${flag.slice(4, -1)}" is in the served page source`);

  // 2. Tutorial at desktop and phone widths.
  for (const vp of [{ width: 1366, height: 860, tag: 'desktop' }, { width: 390, height: 844, tag: 'phone' }]) {
    const { ctx, page, errors } = await freshPage(browser, { width: vp.width, height: vp.height });
    let tut = await page.evaluate(findTutorial);
    report.info[`tutorial_${vp.tag}`] = tut ? { id: tut.id, cls: tut.cls } : null;
    if (!tut) { fail(`${vp.tag}: tutorial did not open on first visit`); }
    else {
      const canScroll = await page.evaluate(() => document.documentElement.scrollHeight > innerHeight + 5);
      if (canScroll) {
        await page.mouse.move(vp.width / 2, vp.height / 2);
        await page.mouse.wheel(0, 600);
        await page.waitForTimeout(250);
        const y = await page.evaluate(() => scrollY);
        if (y > 5) fail(`${vp.tag}: page behind the tutorial scrolls (scrollY=${y})`);
        await page.evaluate(() => scrollTo(0, 0));
      }
      for (let i = 0; i < 15 && tut; i++) {
        await page.screenshot({ path: path.join(outDir, `tutorial-${vp.tag}-step${i + 1}.png`) });
        for (const b of tut.buttons) {
          if (!b.inView) fail(`${vp.tag}: tutorial step ${i + 1} button "${b.text}" is off screen`);
          else if (b.covered) fail(`${vp.tag}: tutorial step ${i + 1} button "${b.text}" is covered by another element`);
        }
        if (!tut.buttons.length) warn(`${vp.tag}: tutorial step ${i + 1} has no Next/Skip/Close button found`);
        const next = page.locator('button, a, [role="button"]').filter({ hasText: /^\s*(next|finish|done|got it|start)\b/i }).locator('visible=true').first();
        if (!(await next.count())) break;
        await next.click().catch(() => {});
        await page.waitForTimeout(350);
        tut = await page.evaluate(findTutorial);
      }
      report.info[`tutorial_${vp.tag}_steps`] = (fs.readdirSync(outDir).filter(f => f.startsWith(`tutorial-${vp.tag}`))).length;
    }
    // Reload: should not auto-open again.
    await page.reload(); await page.waitForTimeout(700);
    if (await page.evaluate(findTutorial)) fail(`${vp.tag}: tutorial opens again after it was finished (first-visit flag not kept)`);
    // Reopen from its button, Escape closes.
    const open = page.locator('button, a').filter({ hasText: /tutorial/i }).locator('visible=true').first();
    if (await open.count()) {
      await open.click(); await page.waitForTimeout(350);
      if (!(await page.evaluate(findTutorial))) fail(`${vp.tag}: View Tutorial button does not open the tutorial`);
      await page.keyboard.press('Escape'); await page.waitForTimeout(350);
      if (await page.evaluate(findTutorial)) fail(`${vp.tag}: Escape does not close the tutorial`);
    } else fail(`${vp.tag}: no visible "View Tutorial" button`);
    const over = await page.evaluate(() => document.documentElement.scrollWidth - innerWidth);
    if (over > 2) fail(`${vp.tag}: page scrolls sideways by ${over}px`);
    await page.screenshot({ path: path.join(outDir, `practical-${vp.tag}.png`), fullPage: true });
    allErrors.push(...errors);
    await ctx.close();
  }

  // 3. Room-specific solve, traps, reset.
  if (spec) {
    const run = async (name, list) => {
      const { ctx, page, errors } = await freshPage(browser, { width: 1366, height: 860 });
      await page.keyboard.press('Escape'); await page.waitForTimeout(200);
      let err = null;
      try { await steps(page, list); } catch (e) { err = e.message.split('\n')[0]; }
      await page.waitForTimeout(400);
      const body = await page.evaluate(() => document.body.innerText);
      allErrors.push(...errors);
      return { ctx, page, body, err };
    };
    if (spec.solve) {
      const r = await run('solve', spec.solve.steps);
      if (r.err) fail(`solve: step failed: ${r.err}`);
      report.info.solveShowsFlag = r.body.includes(spec.solve.expectText);
      if (!report.info.solveShowsFlag) fail(`solve: "${spec.solve.expectText}" not shown after the solve steps`);
      await r.page.screenshot({ path: path.join(outDir, 'solve.png'), fullPage: true });
      if (spec.reset) {
        try { await steps(r.page, spec.reset.steps); } catch (e) { fail('reset: step failed: ' + e.message.split('\n')[0]); }
        await r.page.waitForTimeout(300);
        const after = await r.page.evaluate(() => document.body.innerText);
        if (after.includes(spec.reset.expectHidden)) fail('reset: flag still shown after Reset');
        await r.page.screenshot({ path: path.join(outDir, 'after-reset.png'), fullPage: true });
      }
      await r.ctx.close();
    }
    for (const t of spec.traps || []) {
      const r = await run(t.name, t.steps);
      if (r.err) fail(`trap "${t.name}": step failed: ${r.err}`);
      if (spec.solve && r.body.includes(spec.solve.expectText)) fail(`trap "${t.name}": flag is revealed`);
      if (!/Not yet\./.test(r.body)) warn(`trap "${t.name}": "Not yet." not shown`);
      if (/\b\d+\s*(of|\/)\s*\d+\s*(are\s*)?(right|correct)/i.test(r.body)) fail(`trap "${t.name}": feedback shows a counter`);
      await r.page.screenshot({ path: path.join(outDir, `trap-${t.name.replace(/\W+/g, '-')}.png`) });
      await r.ctx.close();
    }
  }
  report.errors = [...new Set(allErrors)];
  for (const e of report.errors) fail(e);
  await browser.close();
  console.log(JSON.stringify(report, null, 2));
  process.exit(report.fail.length ? 1 : 0);
})().catch(e => { console.error(e); process.exit(2); });
