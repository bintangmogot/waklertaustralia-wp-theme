---
name: two-tone-dashed-ui-redesign
description: >-
  Complete design system and frontend engineering skill for creating and redesigning
  high-converting e-commerce, pharmacy, and content websites using the Modern 2-Tone
  Dashed UI Architecture (Tailwind CSS + WordPress ACF). Use whenever building or
  redesigning pages, cards, heroes, legal/policy layouts, FAQs, blog archives, or
  WYSIWYG comparison tables.
---

# Modern 2-Tone Dashed UI Design System & Redesign Skill

Use this skill to design, build, or overhaul any website into a high-trust, high-conversion **2-Tone Dashed UI Architecture**. Every component follows strict visual hierarchy, compact spacing, tactile dashed borders, two-tone surfaces, colorful vector iconography, and 100% dynamic CMS editability.

---

## 1. Core Brand & Color Token Architecture

Never use random framework default colors (e.g., random lime green, generic grey borders, or muddy beige/yellow table cells). Map the target brand into these semantic roles using CSS variables or Tailwind tokens:

| Semantic Token | Default Reference Hex | Usage Rules |
| :--- | :--- | :--- |
| **Primary Deep (`--color-primary-dark`)** | `#0c4161` (Pacific Navy) | H1/H2/H3 headings, active states, table headers, primary text emphasis, dark card footers on hover. |
| **Primary Darker (`--color-navy-deep`)** | `#082c42` / `#062235` | Hero gradients, featured table header columns, footer backgrounds. |
| **Brand Accent (`--color-primary`)** | `#0284c7` / `#38bdf8` | Dashed borders (`border-sky-300/80`), interactive focus rings, subtle icon badges. |
| **Tinted Surface (`--color-surface`)** | `#f0f6fa` / `#f8fafc` | 2-tone card headers/footers, section backgrounds, alternating table rows, feature label columns. |
| **Conversion Accent (`--color-cta`)** | `#f59e0b` / `#fbbf24` (Amber/Gold) | Primary CTA buttons, floating category badges, rating stars, featured column dividers. |
| **Body Ink (`--color-ink`)** | `#1e293b` / `#334155` | Clean, high-contrast slate body copy. |
| **Muted Text (`--color-muted`)** | `#64748b` | Timestamps, captions, secondary metadata. |

---

## 2. Non-Negotiable Layout & Spacing Rules

1. **Compact Vertical Rhythm**:
   - Keep section vertical padding tight (`py-8` to `py-12` on desktop, `py-6` on mobile). Avoid bloated `py-20` or `py-24` gaps.
   - Avoid unnecessary `<hr>` dividers that cut up related content.
2. **Signature 2-Tone Dashed Borders**:
   - Standardize card containers with `rounded-2xl` or `rounded-3xl` (`1.5rem` radius), crisp white backgrounds (`bg-white`), and 2px dashed borders (`border-2 border-dashed border-sky-300/80` or `border-sky-200/80`).
   - Pair cards with subtle elevation (`shadow-xs` or `shadow-sm`) and smooth hover lift (`hover:-translate-y-1 hover:border-[#0c4161] transition-all duration-300`).
3. **Colorful Multi-Tone SVG Icons**:
   - Never use plain monochrome icons when representing features, trust badges, shipping partners, or metadata.
   - Use multi-tone SVGs (e.g., sky blue + amber + emerald accents) housed inside soft tinted icon boxes (`w-10 h-10 rounded-xl bg-sky-50 border border-sky-200/80`).
4. **Fit-to-Content Badges & Pills**:
   - Badges, buttons, and footer callout boxes must use `w-fit` / `inline-flex` instead of stretching awkwardly across full container widths.

---

## 3. Component Blueprints

### A. Compact Page Hero Banner
Used across internal pages (About, Contact, Track Order, FAQ, Legal Policies, Blog):
- **Background**: Deep gradient (`bg-gradient-to-br from-[#062033] via-[#0c4161] to-[#093552]`) with a subtle dot pattern overlay and `border-b-2 border-dashed border-sky-300/30`.
- **Eyebrow Pill**: `inline-flex items-center gap-2 rounded-full bg-amber-400/15 border border-amber-300/40 px-3.5 py-1 text-xs font-black uppercase tracking-widest text-amber-300`.
- **Headline**: Centered `font-heading text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black text-white leading-tight`.
- **Trust Pills / Metadata Bar**: Compact inline pills below the subtitle displaying key assurances or "Last Updated" timestamps.

### B. 2-Tone Dashed Blog & Content Cards
Used on Blog Archives, Guides, and Related Content grids:
- **Outer Shell**:
  ```html
  <article class="group bg-white rounded-3xl border-2 border-dashed border-sky-300/80 overflow-hidden shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col h-full hover:-translate-y-1">
  ```
- **Visual Header Banner**:
  - Aspect ratio `aspect-[16/10]` with image zoom on hover (`group-hover:scale-105`), OR a branded dark navy gradient fallback graphic featuring a centered vector book/insight icon.
  - **Floating Category Pill**: Positioned at `top-3 left-3` using `bg-amber-400 text-amber-950 text-[10px] sm:text-xs font-black uppercase tracking-wider px-3 py-1 rounded-full shadow-md`.
- **Card Body**:
  - Metadata row with a cyan calendar SVG (publish date) and amber clock SVG (reading time).
  - Bold Pacific Navy title (`font-heading font-black text-lg sm:text-xl text-[#0c4161] group-hover:text-sky-900 line-clamp-2`).
  - Clean 3-line excerpt (`text-sm text-slate-600 line-clamp-3`).
- **2-Tone Dashed Footer Block**:
  ```html
  <a href="..." class="bg-[#f0f6fa] group-hover:bg-[#0c4161] p-3.5 px-5 sm:px-6 border-t-2 border-dashed border-sky-200/80 flex items-center justify-between transition-colors duration-300 text-xs sm:text-sm font-black text-[#0c4161] group-hover:text-white mt-auto">
    <span>Read Full Guide</span>
    <svg class="w-4 h-4 transform group-hover:translate-x-1.5 transition-transform duration-300" ...>...</svg>
  </a>
  ```

### C. Two-Column Legal, Policy & Guide Layout
Used on Shipping Policy, Privacy Policy, Refund Policy, Terms & Conditions, Medical Disclaimer, and Buyer's Guides:
- **Left Column (Sticky Table of Contents + Support Box)**:
  - `lg:col-span-4 lg:sticky lg:top-28 space-y-5`
  - **TOC Card**: `rounded-2xl border-2 border-dashed border-sky-200/80 bg-white p-5 shadow-xs`. Each link shows a compact `01`, `02` badge (`bg-sky-50 text-[#0c4161] font-mono text-xs font-bold px-2 py-0.5 rounded-md`) + section title.
- **Right Column (Single Unified Content Card)**:
  - **CRITICAL RULE**: Do **NOT** split each policy section into separate disconnected boxes on the right column. Place all sections inside **one unified card container**:
    ```html
    <article class="rounded-2xl sm:rounded-3xl border-2 border-dashed border-sky-200/80 bg-white p-6 sm:p-10 shadow-xs divide-y divide-dashed divide-sky-200/80">
    ```
  - **Section Header Format**:
    - Do **not** output verbose `"Section 1"` text.
    - Output a small, visible numeric badge (`01`, `02`, `03`) directly above the heading:
      ```html
      <div class="mb-2">
        <span class="inline-flex items-center justify-center rounded-md bg-sky-100 px-2 py-0.5 font-mono text-[11px] font-extrabold text-[#0c4161]">01</span>
      </div>
      <h2 class="font-heading text-xl sm:text-2xl font-black leading-tight text-[#0c4161]">Section Title</h2>
      ```

### D. 2-Tone Dashed FAQ Accordions
Used on dedicated FAQ pages and product FAQ modules:
- **Category Filter Pills**: Rounded-full dashed buttons (`border-2 border-dashed border-sky-300/80`) that switch to solid `#0c4161` text-white when active.
- **Accordion Item (`<details class="group">`)**:
  - Container: `rounded-2xl border-2 border-dashed border-sky-200/80 bg-white overflow-hidden transition-all duration-200 open:border-[#0c4161] open:shadow-md`.
  - Summary (`<summary>`): `flex cursor-pointer items-center justify-between gap-4 px-5 py-4 font-heading text-base sm:text-lg font-black text-[#0c4161] select-none`. Includes a numbered badge (`01`, `02`) on the left and a rotating `+` icon badge on the right (`group-open:rotate-45 group-open:bg-[#0c4161] group-open:text-white`).
  - Answer Body: 2-tone tinted bottom tray (`border-t-2 border-dashed border-sky-100 bg-[#f8fafc] px-5 py-4 text-sm sm:text-base text-slate-600 prose max-w-none`).

---

## 4. WYSIWYG Editor & Comparison Table Redesign Standard

Tables inside product descriptions, blog posts, and guides (`.prose table`, `.table-wrapper`, `figure.wp-block-table`) must be automatically upgraded into responsive 2-tone dashed cards with intelligent hero column highlighting.

### A. Automatic Wrapper & Intelligent Highlighting Script (`main.js`)
1. **Normalize `<thead>`**: If a WYSIWYG table lacks a `<thead>`, promote the first `<tr>` into a `<thead>` automatically.
2. **Responsive Scroll Container**: Wrap standalone tables in `<div class="table-wrapper">`.
3. **Page-Aware Hero Column Detection**:
   - Inspect `thead th, thead td` against the current page `<h1>` title.
   - If a column header matches the current product/page title (e.g., *"Waklert 150mg"* on the Waklert page, or *"Artvigil 150mg"* on the Artvigil page), add `.waklert-highlight-header` to that header cell and `.waklert-highlight-cell` to all body cells in that column.
   - Fallback to columns matching brand keywords (`waklert`, `recommended`) or the last column in 3+ column comparison tables.

```javascript
document.querySelectorAll('.prose table').forEach((table) => {
    // 1. Ensure thead exists
    if (!table.querySelector('thead')) {
        const firstRow = table.querySelector('tbody tr:first-child, tr:first-child');
        if (firstRow) {
            const thead = document.createElement('thead');
            thead.appendChild(firstRow);
            table.insertBefore(thead, table.firstChild);
        }
    }

    // 2. Wrap in responsive .table-wrapper
    if (!table.parentElement.classList.contains('table-wrapper') && !table.closest('figure.wp-block-table')) {
        const wrapper = document.createElement('div');
        wrapper.className = 'table-wrapper';
        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(table);
    }

    // 3. Intelligently highlight the featured column matching the current page
    const headerCells = table.querySelectorAll('thead th, thead td');
    if (headerCells.length >= 2) {
        let highlightIdx = -1;
        const pageHeading = (document.querySelector('h1')?.textContent || '').trim().toLowerCase();

        if (pageHeading) {
            headerCells.forEach((th, idx) => {
                const txt = th.textContent.trim().toLowerCase();
                if (idx > 0 && txt && (pageHeading.includes(txt) || txt.includes(pageHeading.split(' ')[0]))) {
                    highlightIdx = idx;
                }
            });
        }

        if (highlightIdx === -1) {
            headerCells.forEach((th, idx) => {
                const txt = th.textContent.trim().toLowerCase();
                if (idx > 0 && (txt.includes('waklert') || txt.includes('recommended'))) {
                    highlightIdx = idx;
                }
            });
        }

        if (highlightIdx === -1 && headerCells.length >= 3) {
            highlightIdx = headerCells.length - 1;
        }

        if (highlightIdx !== -1) {
            headerCells[highlightIdx].classList.add('waklert-highlight-header');
            table.querySelectorAll(`tbody tr td:nth-child(${highlightIdx + 1}), tbody tr th:nth-child(${highlightIdx + 1})`).forEach((td) => {
                td.classList.add('waklert-highlight-cell');
            });
        }
    }
});
```

### B. Complete CSS Specification for WYSIWYG Tables
```css
/* 1. Responsive Dashed Outer Container */
.prose .table-wrapper,
.prose figure.wp-block-table {
  width: 100%;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  margin: 2rem 0;
  border: 2px dashed rgba(125, 211, 252, 0.85);
  border-radius: 1.5rem;
  background-color: #ffffff;
  box-shadow: 0 4px 20px -4px rgba(12, 65, 97, 0.08), 0 2px 6px -1px rgba(12, 65, 97, 0.04);
}

.prose .table-wrapper table,
.prose figure.wp-block-table table {
  width: 100%;
  min-width: 100%;
  margin: 0;
  border: none;
  border-radius: 0;
  border-collapse: separate;
  border-spacing: 0;
}

/* 2. Pacific Navy Header Gradient */
.prose thead {
  background: linear-gradient(135deg, #0c4161 0%, #082c42 100%);
  border-bottom: 2px solid rgba(12, 65, 97, 0.3) !important;
}

.prose thead th,
.prose thead td,
.prose th {
  font-family: var(--font-heading, inherit);
  font-weight: 800;
  font-size: 0.9375rem;
  letter-spacing: 0.02em;
  color: #ffffff !important;
  padding: 1.125rem 1.35rem;
  vertical-align: middle;
  background: transparent;
  border-bottom: 2px solid rgba(12, 65, 97, 0.3) !important;
  border-right: 1px dashed rgba(255, 255, 255, 0.18) !important;
  text-align: left;
}

.prose thead th *,
.prose thead td *,
.prose th * {
  color: #ffffff !important;
  font-weight: 800;
}

/* 3. Body Rows & Dashed Horizontal Dividers */
.prose tbody tr {
  background-color: #ffffff;
  transition: background-color 0.15s ease-in-out;
}

.prose tbody tr:nth-child(even) {
  background-color: #f8fafc;
}

.prose tbody tr:hover {
  background-color: #f0f7fd !important;
}

.prose tbody td {
  padding: 1rem 1.35rem;
  border-bottom: 1px dashed rgba(186, 230, 253, 0.75) !important;
  color: #334155;
  font-size: 0.9375rem;
  line-height: 1.6;
}

.prose tbody tr:last-child td {
  border-bottom: none !important;
}

/* 4. First Column (Feature / Attribute Name) */
.prose tbody td:first-child,
.prose tbody th:first-child {
  font-family: var(--font-heading, inherit);
  font-weight: 800;
  color: #0c4161 !important;
  background-color: rgba(240, 246, 250, 0.5);
  border-right: 1px dashed rgba(186, 230, 253, 0.65) !important;
}

.prose tbody td:first-child * {
  color: #0c4161 !important;
  font-weight: 800;
}

/* 5. Highlighted Hero Product Column */
.prose thead th.waklert-highlight-header,
.prose thead td.waklert-highlight-header {
  background: linear-gradient(135deg, #09344e 0%, #062235 100%) !important;
  color: #ffffff !important;
  border-left: 2px dashed rgba(251, 191, 36, 0.65) !important;
}

.prose tbody tr td.waklert-highlight-cell {
  background-color: rgba(224, 242, 254, 0.4) !important;
  font-weight: 700;
  color: #0c4161 !important;
  border-left: 1px dashed rgba(125, 211, 252, 0.8) !important;
}

.prose tbody tr:nth-child(even) td.waklert-highlight-cell {
  background-color: rgba(224, 242, 254, 0.6) !important;
}

.prose tbody tr:hover td.waklert-highlight-cell {
  background-color: rgba(186, 230, 253, 0.8) !important;
}
```

---

## 5. WordPress & ACF Dynamic Content Rule (Zero Hardcoding)

1. **Never Hardcode Page Copy**: Every heading, eyebrow badge, paragraph, table, FAQ item, and CTA button must pull from WordPress Admin (ACF Flexible Content `get_sub_field()` / `get_field()` or post content) with clean fallbacks.
2. **Database Seeding**: When migrating or creating new ACF modules, automatically seed the database (`wp_postmeta`) with both the values and the ACF field key references (`_modules_0_*`) so the client can immediately edit all text inside WP Admin without blank fields.
3. **Visual Verification**: Always compile Tailwind CSS (`npm run build`) and verify desktop and mobile viewports with browser screenshots before completing any redesign task.
