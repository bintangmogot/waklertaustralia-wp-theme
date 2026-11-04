---
name: acf-content-registry
description: Extend or maintain this theme's JSON-backed ACF content controls and empty-field installer. Use for template copy, icons and bundled media defaults; native product data and ordinary page editing keep their existing admin sources.
---

Read [the content editing and maintenance guide](../../../docs/editable-content.md)
for admin locations, registry sources and verification commands.

Before adding a field, find its existing ACF or native WordPress/WooCommerce
owner. Reuse its stable field name and key instead of creating competing values.
Registry entries can bind to an original scalar field with `field_name` and
`field_key`; module entries also specify the existing layout name in `module`.

For new controls, add a stable key, type, default, source and label to the content
registry. Generate definitions with `tools/generate-content-fields.py`. Preserve
existing layout keys, row values and field references. Do not infer page content
from product titles, fixed database IDs or client data from another site.

Keep defaults as data. Install into initially empty fields once, preserve zero,
and respect subsequent edits and clears. Parent module lookup must work inside
nested repeaters. Reordering a cleared module must not repopulate its fields.

Use the icon helper for editable SVG and image overrides. Validate with real
WordPress KSES: it lowercases attribute names, so SVG `viewBox` needs canonical
spelling restored. Preserve layout dimensions when an image replaces an icon.
Rebuild Tailwind when classes in JSON artwork change.

Audit PHP and HTML boundaries before moving literals. PHP closing tags can look
like HTML tag endings inside attributes; blind text replacement corrupts markup.
Encode text inserted into JavaScript as JSON with HTML-safe flags.

Run schema, runtime, local integration and relevant browser checks from the guide.
The PHP integration scripts are CLI-only, restore temporary values, isolate
unsaved-order rendering and block mail. Report the actual browser coverage and
keep build success separate from deployment evidence.
