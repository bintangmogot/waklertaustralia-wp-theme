# Editing Waklert content

Page copy and layout settings remain under **Pages → Edit page → Modules**.
Existing fields keep their names, values and positions. Additional labels appear in the module's **Additional text** tab. Generated SVG
code, artwork overrides and punctuation-only controls are hidden from WP Admin; their stored artwork
continues to render on the frontend.

Shared template controls are under **Theme Settings**:

| Admin page | Content |
| --- | --- |
| Content: Header & Footer | Navigation controls, accessibility labels, branding defaults and icons |
| Content: Pages | Standalone pages, blog labels, delivery page and page fallbacks |
| Content: Storefront | Product/review labels, icons, empty states and review feedback |
| Content: Checkout | Cart, order details, thank-you icons and receipt-message templates |
| Content: Emails | Customer email copy, greetings, image fallbacks and headings |
| Content: System Messages | Commerce validation messages, interaction feedback and the icon library |

The main Theme Settings tabs still own contact details, payment information,
footer logo lists, product presentation and the existing checkout/thank-you copy.
Existing fields are reused whenever they already cover a value.

Generated icon code, icon image overrides and bundled artwork controls stay out
of the content editor. Existing saved artwork and frontend rendering are retained.
Normal content image selectors, such as hero images and product images, remain
available. SVG values are restricted to inert artwork.

Products, prices, variations, stock, reviews, menus, site identity and existing
form settings continue to use their native WordPress, WooCommerce and form admin
controls. These values are read dynamically; they are not duplicated into ACF.
Email sender identity, footer text and appearance use WooCommerce's Email settings.
WordPress/plugin interface strings, technical route names, CSS layout tokens,
numeric counters and transaction calculations remain implementation or native
plugin behavior. The theme's existing operational mail routing is unchanged.

## Defaults and preservation

`inc/data/content-defaults.json` contains the original module, option and FAQ
seed data. `inc/data/template-content*.json` describes the remaining template
text, icons and images. `acf-json` stores the corresponding ACF definitions.

When an administrator opens WP Admin, the installer fills newly introduced empty
fields. It preserves existing non-empty values. After installation, a deliberate
clear remains empty. ACF saves also install defaults for newly added module rows.
Bundled image defaults are copied into this site's Media Library once, with
attachment reuse to avoid duplicate imports. Frontend requests read saved values without replacing cleared content.

The installer has a lock to prevent concurrent imports. Existing module rows,
including nested repeaters, keep their content and field references. Saved
contact values, city names and email appearance settings are no longer rewritten
by historical migrations. Bank transfer details retain their existing canonical
Theme Settings source; native WooCommerce account display remains synchronized.

Messages using `{order}`, `{total}`, `{name}` or `%s` retain those placeholders
for dynamic information. ACF validates printf-style placeholders before saving.

## Developer checks

Generate fields after changing registry data:

```powershell
python tools/generate-content-fields.py
npm run build
python tests/content-schema.py
php tests/template-content-runtime.php
php tests/content-integration.php
node tests/content-browser.cjs
```

The integration test is restricted to the local site. It restores its temporary
content edits and sends no mail or orders. Unsaved-order checks isolate the theme
templates from third-party thank-you hooks that require a persisted order.
Browser checks inspect public pages and a guest cart/checkout in an isolated
session, then remove their cart item. The build compiles Tailwind classes stored with
the JSON icon defaults. These checks do not prove production deployment.

## Empty module fields

Clearing a module heading, description, badge or button hides its frontend element.
Whitespace and empty rich-text markup also count as empty. A button needs both a
label and a destination. Empty repeater cards and sections are omitted. The ACF
fields and layouts remain available: enter content and save the page to show them
again. Text defaults are not frontend replacements for cleared text fields.
Saved empty values are preserved when the installer runs again.

Check without changing database content: `php tests/module-visibility.php` and
`php tests/module-seed-preservation.php`.

### Image and icon fallbacks

Images and icons use saved artwork when present. When those artwork values are
blank, render their existing bundled defaults. The hero uses separate desktop
and mobile assets when its corresponding image selector is empty. This does not
restore cleared text, buttons, badges or repeater rows, or refill database values.
Generated artwork controls remain hidden in WP Admin; normal image selectors stay
available. A completely cleared module remains hidden.

### Existing live content takes priority

Automatic initialization may fill missing fields. It must not replace existing
FAQ questions, answers, saved repeater rows, text or artwork. A saved empty field
remains an editor-controlled clear. Existing FAQ/repeater children are preserved
even when their parent row count is absent. Deployment never copies the local
WordPress database into the hosted site.

### Companion containers and icons

Optional text controls its decorative companions. Clearing the mega-menu heading,
delivery badge, bottom note or button label also hides its icon, pill or button.
Header/footer strips disappear when none of their content is visible. The product
links remain available. The mobile help card, mission/vision cards and coloured
card-description panels follow the same rule. An FAQ without a question does not
render an empty icon-only accordion. These checks do not alter saved content or
remove editor fields. Verify with `php tests/menu-empty-content.php` and
`php tests/module-visibility.php`.

### Restrained border and background treatment

Use solid lines for navigation, section dividers, table rows/columns, reviews,
FAQ accordions, buttons and internal card dividers. Dashed borders are reserved
for the outer product-card and key-point-card outlines. Dot/grid textures and
large circular background rings are disabled. This is presentation only; saved
page content and artwork fallback rules are unchanged.
