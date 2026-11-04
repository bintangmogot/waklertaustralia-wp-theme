/* Public rendering checks with an isolated guest cart. No order is submitted. */
const puppeteer = require('puppeteer');
const fs = require('node:fs');
const path = require('node:path');
const base = 'http://waklertaustralia.com.test';
const output = path.join(process.env.TEMP || 'C:/Temp', 'waklert-content-review');
fs.mkdirSync(output, {recursive: true});
(async () => {
  const browser = await puppeteer.launch({headless: true, args: ['--no-proxy-server', '--host-resolver-rules=MAP waklertaustralia.com.test 127.0.0.1']});
  try {
    const page = await browser.newPage();
    const errors = [];
    page.on('pageerror', e => errors.push(e.message));
    await page.setViewport({width: 1366, height: 900});
    await page.goto(base, {waitUntil: 'networkidle2', timeout: 60000});
    const links = await page.$$eval('a[href]', nodes => nodes.map(n => n.href));
    const product = links.find(href => href.startsWith(base + '/product/'));
    const urls = process.argv.includes('--commerce-only') ? [base + '/', product].filter(Boolean) : [...new Set([base + '/', base + '/shop/', ...links.filter(href => href.startsWith(base) && /\/(about-us|contact|faq|track-order|blog|australia-delivery)\/?$/.test(href)), product, base + '/cart/'].filter(Boolean))];
    const results = [];
    for (const url of urls) {
      const response = await page.goto(url, {waitUntil: 'networkidle2', timeout: 60000});
      const state = await page.evaluate(() => ({title: document.title, fatal: /Fatal error|Parse error|There has been a critical error/.test(document.body.innerText), brokenImages: [...document.images].filter(i => i.getBoundingClientRect().width > 0 && i.complete && i.naturalWidth === 0).map(i => new URL(i.src).pathname)}));
      if (!response || response.status() >= 400 || state.fatal) throw new Error('Page failed: ' + url);
      results.push({url: new URL(url).pathname, status: response.status(), ...state});
      if (url === base + '/') await page.screenshot({path: path.join(output, 'home-desktop.png'), fullPage: true});
      console.log('Checked ' + new URL(url).pathname);
    }
    if (!product) throw new Error('No product link was found.');
    await page.goto(product, {waitUntil: 'networkidle2', timeout: 60000});
    await page.evaluate(async () => {
      const form = [...document.forms].find(form => form.querySelector('[name="add-to-cart"]'));
      if (!form) throw new Error('Product cart form missing.');
      await fetch(form.action || location.href, {method: 'POST', body: new FormData(form), credentials: 'same-origin'});
    });
    await page.goto(base + '/cart/', {waitUntil: 'networkidle2', timeout: 60000});
    await page.waitForSelector('.woocommerce-cart-form', {timeout: 15000});
    const removeUrl = await page.$eval('.woocommerce-cart-form a.remove', a => a.href);
    await page.screenshot({path: path.join(output, 'cart-desktop.png'), fullPage: true});
    await page.goto(base + '/checkout/', {waitUntil: 'networkidle2', timeout: 60000});
    await page.waitForSelector('form.checkout', {timeout: 15000});
    const checkoutFields = await page.$$eval('form.checkout input[name]', nodes => nodes.length);
    await page.screenshot({path: path.join(output, 'checkout-desktop.png'), fullPage: true});
    console.log('Verified nonempty cart and checkout form (' + checkoutFields + ' inputs); no order submitted.');
    await page.goto(removeUrl, {waitUntil: 'networkidle2', timeout: 60000});
    await page.setViewport({width: 390, height: 844});
    await page.goto(base, {waitUntil: 'networkidle2', timeout: 60000});
    await page.screenshot({path: path.join(output, 'home-mobile.png'), fullPage: true});
    const mobile = await page.evaluate(() => ({viewport: innerWidth, document: document.documentElement.scrollWidth}));
    fs.writeFileSync(path.join(output, process.argv.includes('--commerce-only') ? 'commerce-results.json' : 'results.json'), JSON.stringify({results, errors, mobile, checkoutFields}, null, 2));
    if (errors.length) throw new Error('Browser errors: ' + errors.join('; '));
    if (results.some(r => r.brokenImages.length)) throw new Error('Broken visible images found; inspect results.json.');
    console.log(JSON.stringify({pages: results.length, mobile, output}));
  } finally { await browser.close(); }
})().catch(error => { console.error(error.message); process.exitCode = 1; });
