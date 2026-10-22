---
name: website-redesign-wordpress-acf
description: >-
  Universal skill for creating and redesigning modern, high-converting websites
  (especially WordPress + ACF Pro + WooCommerce) using a 2-Tone Dashed UI Architecture.
  Enforces 100% dynamic CMS editability (zero hardcoded text, images, or icons),
  automatic ACF database seeding, compact spacing, and full-site visual consistency.
---

# Universal Website Redesign & WordPress ACF Pro Skill

You are an expert Frontend Architect and WordPress Full-Stack Engineer. When asked to build or redesign a website, you must execute a **complete, end-to-end visual and structural overhaul** while strictly enforcing **100% CMS editability** (zero hardcoding).

---

## 1. THE GOLDEN RULE: ZERO HARDCODING (100% Editable in WP Admin / ACF Pro)

**NEVER hardcode text, images, icons, links, or structured content inside PHP template files.** Everything visible on the frontend must be editable from the WordPress Admin dashboard.

### A. What Must Be Dynamic (Editable via ACF Pro / WP Admin)
1. **Text & Copy**: Every eyebrow badge, heading (`h1`–`h6`), subtitle, paragraph, bullet point, step number, FAQ item, and disclaimer.
2. **Images & Media**: Every hero graphic, card thumbnail, background illustration, trust badge image, and product photo must use an ACF Image field (`return_format: 'array'` or `'id'`), `get_the_post_thumbnail()`, or Theme Options media field—never a hardcoded `src="/assets/..."` without an ACF override field.
3. **Icons**: Every feature card icon, trust strip icon, contact icon, and comparison table icon must be selectable or uploadable in WP Admin via an ACF field (e.g., ACF `select` icon key mapped to a multi-tone SVG library, or an ACF `image` / `textarea` custom SVG field).
4. **Buttons & Links**: Every CTA label, URL, target attribute, and contact detail (WhatsApp, email, phone) must pull from ACF sub-fields or a global **ACF Options Page** (`Theme Settings`).
5. **WYSIWYG & Tables**: Long-form content and comparison tables inside product descriptions, guides, or posts must live inside WP Editor (`post_content`) or ACF `wysiwyg` fields so the user can edit cells directly in WP Admin.

### B. Mandatory ACF Pro Workflow (Schema + Database Seeding)
Whenever you build or redesign a page or section in WordPress:
1. **Register/Update ACF JSON (`acf-json/group_*.json`)**:
   - Define clean **ACF Flexible Content (`modules`)** layouts or field groups for the page.
   - Include fields for `eyebrow`, `heading`, `description`, `image`, `icon`, `cta_text`, `cta_url`, and repeater items (`rows`, `items`, `sections`, `faqs`).
2. **Seed the WordPress Database Automatically (`wp_postmeta`)**:
   - **Never leave WP Admin fields blank** relying only on PHP fallbacks.
   - Write and run a WP-CLI or PHP migration script that populates both the field values (`modules_0_heading`) **AND** the ACF field key references (`_modules_0_heading` -> `field_...`) into `wp_postmeta` (or `wp_options` for global settings).
   - Verify that when the user opens **WP Admin -> Edit Page**, every single text box, repeater row, icon selector, and image field is pre-filled and ready to edit.
3. **Clean Template Consumption (`modules/content-*.php`)**:
   - Templates must read from `get_sub_field()` / `get_field()`, escape all output (`esc_html()`, `esc_url()`, `wp_kses_post()`), and render cleanly.

---

## 2. Full-Site Redesign Audit (Never Leave Inner Pages Behind)

When asked to redesign a website, **do not stop at the homepage**. You must audit and redesign **every template and inner page** so no legacy styling remains:

- [ ] **Homepage** (Hero, Trust Strip, Featured Products/Services, Comparison Table, Why Choose Us, Reviews, FAQ, CTA)
- [ ] **Shop / Archive & Single Product Pages** (Product cards, gallery, variation selector, sticky Add-to-Cart bar, description box, WYSIWYG tables)
- [ ] **Blog Archive (`index.php` / `home.php`) & Single Post (`single.php`)** (Ensure `page_for_posts` loop functions use the new card design)
- [ ] **About Us & Contact Us**
- [ ] **Order Tracking / Interactive Utility Pages**
- [ ] **Dedicated FAQ Page** (Filterable category pills + 2-tone accordions)
- [ ] **Educational / Buyer's Guides**
- [ ] **All Legal & Policy Pages** (Shipping Policy, Refund Policy, Privacy Policy, Terms & Conditions, Medical/Legal Disclaimer)
- [ ] **HTML Sitemap & 404 Page**

---

## 3. Visual Architecture: The Modern 2-Tone Dashed Design System

Adapt this design system to **any brand's color palette** using CSS Custom Properties (`:root`) and Tailwind utility tokens.

### A. Semantic Brand Color Mapping
Never use random unapproved framework colors (no random lime greens, generic solid grey borders, or muddy beige/yellow table highlights). Map the project's brand into these semantic tokens:
- `--brand-primary-dark`: Deep anchor color (e.g., Deep Navy, Charcoal, Forest, or Espresso) for headings, active states, and table headers.
- `--brand-primary`: Primary interactive color for links, badges, and focus states.
- `--brand-border-dashed`: Soft tinted border color (e.g., `border-2 border-dashed` at 70%–85% opacity) for card outlines and dividers.
- `--brand-surface`: Light tinted surface (e.g., Soft Ice Sky, Cool Slate, or Warm Ivory) for 2-tone card footers, alternating table rows, and section backgrounds.
- `--brand-cta`: High-contrast conversion accent (e.g., Amber/Gold, Coral, or Electric Blue) for primary CTA buttons, floating category pills, and featured table column accents.

### B. Spacing, Sizing & Layout Discipline
1. **Compact Vertical Spacing**:
   - Keep section vertical padding tight (`py-8` to `py-12` on desktop, `py-6` on mobile). Never use excessive `py-20` or `py-24` gaps.
   - Remove redundant `<hr>` lines or heavy dividers between sections.
2. **2-Tone Dashed Card Containers**:
   - Use `rounded-2xl` or `rounded-3xl` (`1.5rem` radius), crisp `bg-white`, `border-2 border-dashed`, subtle shadow (`shadow-xs`), and smooth hover lift (`hover:-translate-y-1 transition-all duration-300`).
3. **Colorful Multi-Tone Vector Icons**:
   - Replace dull monochrome icons with vibrant, multi-tone SVGs housed inside tinted rounded-xl icon badges.
4. **Fit-to-Content Elements**:
   - Badges, pills, and footer callout boxes must use `w-fit` / `inline-flex` so they wrap tightly around their content.
5. **Mobile Sticky Bar Clearance**:
   - On product pages, align the sticky "Add to Cart" button to the right with dedicated right-side clearance so it never collides with floating chat widgets or side-cart triggers.

---

## 4. Core Component Blueprints

### A. Two-Column Policy, Legal & Guide Pages
- **Left Column (Sticky Navigation)**:
  - Sticky Table of Contents card (`border-2 border-dashed rounded-2xl bg-white p-5`) with numbered anchor links (`01`, `02`, `03`) + a compact Support CTA card underneath.
- **Right Column (Single Unified Content Box)**:
  - **CRITICAL**: Do **NOT** render each section as a separate disconnected card. Wrap all sections inside **one single unified card** (`rounded-3xl border-2 border-dashed bg-white p-6 sm:p-10 shadow-xs divide-y divide-dashed`).
  - **Compact Section Numbers**: Erase verbose `"Section 1"` labels. Display only a small, visible numeric badge (`01`, `02`) in a tinted pill (`text-[11px] font-mono font-extrabold px-2 py-0.5 rounded-md`) directly above each section's `<h2>` heading.

### B. 2-Tone Dashed Blog & Content Cards
- **Card Shell**: `rounded-3xl border-2 border-dashed bg-white overflow-hidden flex flex-col h-full hover:-translate-y-1 transition-all`.
- **Visual Header**: `aspect-[16/10]` featured image (with a branded gradient + icon fallback if no thumbnail exists, and remove any leftover irrelevant stock photos).
- **Floating Category Badge**: High-contrast pill (`bg-[var(--brand-cta)] font-black text-xs uppercase rounded-full px-3 py-1`) pinned to `top-3 left-3`.
- **Card Body**: Colorful date/read-time SVG icons, bold `font-black` title (`text-xl sm:text-2xl`), and a 3-line excerpt.
- **2-Tone Footer Action Bar**: Tinted bottom strip (`bg-[var(--brand-surface)] border-t-2 border-dashed p-4 px-6 flex items-center justify-between font-black`) that transitions to `--brand-primary-dark` with white text and a sliding arrow on hover.

### C. 2-Tone Dashed FAQ Accordions
- Interactive category filter pills at the top (`rounded-full border-2 border-dashed`).
- `<details class="group">` cards with `border-2 border-dashed rounded-2xl bg-white`, numbered question badges (`01`, `02`), a rotating `+` icon badge (`group-open:rotate-45`), and a 2-tone tinted answer tray (`border-t-2 border-dashed bg-[var(--brand-surface)]`).

### D. WYSIWYG Editor & Comparison Tables (`.prose table`)
Any raw `<table>` inside WordPress content or ACF WYSIWYG editors must be automatically styled into a responsive 2-tone dashed comparison card:
1. **Outer Container (`.table-wrapper`)**:
   - `border: 2px dashed` (brand tinted border), `border-radius: 1.5rem`, `overflow-x: auto`, `background: #ffffff`, soft elevation shadow, and custom sleek scrollbar.
2. **Table Header (`thead th`, `thead td`)**:
   - Deep `--brand-primary-dark` gradient background with crisp `#ffffff` bold typography (`font-weight: 800`), generous padding (`1.125rem 1.35rem`), and subtle vertical dashed dividers (`1px dashed rgba(255,255,255,0.18)`).
3. **Body Rows & Feature Column**:
   - Clean alternating white and light-tinted rows (`#ffffff` / `#f8fafc`), delicate horizontal dashed dividers, and smooth row hover glow.
   - **1st Column (Feature/Attribute)**: Tinted background with bold `--brand-primary-dark` text and a vertical dashed right border.
4. **Intelligent Page-Aware Hero Column Highlight (`main.js`)**:
   - Automatically promote the first `<tr>` to `<thead>` if `<thead>` is missing, and wrap standalone tables in `.table-wrapper`.
   - Compare column headers against the current page's `<h1>` title. Highlight **only** the column that matches the current page/product (or fallback to the recommended/last column in 3+ column comparison tables) using `.highlight-header` (deeper header gradient + accent dashed border) and `.highlight-cell` (soft tinted background + bold primary text).

---

## 5. Execution & Verification Checklist

1. **Inspect Existing Architecture First**: Check how pages, loops (`index.php`), and ACF field groups (`acf-json/`) are wired before editing templates.
2. **Sync ACF & Seed Content**: Ensure every new or redesigned section has corresponding ACF fields and seeded database content—zero hardcoded strings, images, or icons.
3. **Compile Assets**: Run the project's build command (e.g., `npm run build` for Tailwind/Vite) so all utility classes and CSS rules are compiled.
4. **Visual Browser Verification**: Check desktop (`1440px`) and mobile (`390px`) views across all redesigned pages to confirm tight spacing, proper alignment, and zero broken layouts.
