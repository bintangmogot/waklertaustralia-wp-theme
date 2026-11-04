<?php
/**
 * Waklert Australia — Multi-Color Flat Vector Icon Library & Smart Resolver
 *
 * Provides 100% editable + semantically aligned colorful icons across all ACF section modules:
 * - why_choose_us (Audiences / Benefits)
 * - trust_strip (Trust Badges)
 * - how_to_order (Step Cards)
 * - about_delivery (Delivery Feature Cards)
 * - about_mission (Mission & Vision Cards)
 * - track_order (Trust Benefit Cards)
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Return the list of human-readable icon preset choices for ACF Select fields.
 */
function waklert_get_icon_preset_choices(): array {
    return [
        'auto'               => '✨ Auto-Match from Title & Description (Recommended)',
        'parcel_guarantee'   => '🛡️ Parcel Guarantee / Reship or Refund ("If it doesn\'t land, we fix it")',
        'live_chat_support'  => '💬 Real People on Chat / 24/7 SMS & Support',
        'medical_rx_clarity' => '📋 Straight-Up Medicine Info / Schedule 4 & Rx Clarity',
        'aud_checkout'       => '💳 Simple AUD Checkout / PayID & Secure Payment',
        'express_shipping'   => '🚚 Fast Domestic Express Shipping / Australia Post Van',
        'australia_delivery' => '🇦🇺 Australia-Wide Delivery / Tracked Parcel Map',
        'browse_catalogue'   => '💊 Focused Armodafinil Range / Blister Pack Catalogue',
        'listing_details'    => '🔍 Clear Listing Details / Compare Strengths & Packs',
        'returning_loyalty'  => '⭐ Returning Customers / Fast Reorder & Loyalty',
        'discreet_sealed'    => '📦 Discreet Plain Packaging / Sealed Pharmacy Pack',
        'po_box_delivery'    => '📮 PO Box & Parcel Locker Delivery',
        'no_customs'         => '✅ Smooth Domestic Dispatch / No Customs Hassle',
        'affordable_value'   => '💰 Affordable Direct Pricing / Best Value',
    ];
}

/**
 * Return the library of 64x64 multi-color flat vector SVGs keyed by preset slug.
 */
function waklert_get_colorful_icon_svgs(): array {
    return [
        // 1. Parcel Guarantee / Reship or Refund ("If it doesn't land, we fix it")
        'parcel_guarantee' => waklert_content_icon('icon_library_icon_fc5ea46761'),

        // 2. Real People on Chat / 24/7 SMS & Support ("Real people on chat", "Practical support", "Get order support")
        'live_chat_support' => waklert_content_icon('icon_library_icon_e2305dc980'),

        // 3. Straight-Up Medicine Info / Schedule 4 & Rx Clarity ("Straight up about what we sell", "Prescription Customers", "Clear boundaries")
        'medical_rx_clarity' => waklert_content_icon('icon_library_icon_eae3c3f405'),

        // 4. Simple AUD Checkout / PayID & Secure Payment ("Simple AUD checkout", "Secure checkout", "Confirm Your Order")
        'aud_checkout' => waklert_content_icon('icon_library_icon_87afd57c24'),

        // 5. Fast Domestic Express Shipping / Australia Post Van ("Fast, Local Domestic Shipping", "Track Delivery")
        'express_shipping' => waklert_content_icon('icon_library_icon_5fb6fbd893'),

        // 6. Australia-Wide Delivery / Map & Location Pin ("Australia-wide delivery", "Australia-wide Customers", "Delivery details at checkout")
        'australia_delivery' => waklert_content_icon('icon_library_icon_9898049116'),

        // 7. Focused Armodafinil Range / Blister Pack Catalogue ("Focused range", "A focused product category", "Browse the listings", "Review the Range")
        'browse_catalogue' => waklert_content_icon('icon_library_icon_4c3257bedf'),

        // 8. Clear Listing Details / Compare Strengths & Packs ("Clear listing details", "Product details by listing", "Compare listing details", "New Customers")
        'listing_details' => waklert_content_icon('icon_library_icon_d3b476d324'),

        // 9. Returning Customers / Fast Reorder & Loyalty ("Returning Customers")
        'returning_loyalty' => waklert_content_icon('icon_library_icon_f46d6bfeba'),

        // 10. Discreet Plain Packaging / Sealed Pharmacy Pack ("Discreet packaging", "Sealed product packaging")
        'discreet_sealed' => waklert_content_icon('icon_library_icon_b96293c1f7'),

        // 11. PO Box & Parcel Locker Delivery ("PO Box Delivery")
        'po_box_delivery' => waklert_content_icon('icon_library_icon_4db98a9a3e'),

        // 12. Smooth Domestic Dispatch / No Customs Hassle ("No Customs Issues")
        'no_customs' => waklert_content_icon('icon_library_icon_4940d1beed'),

        // 13. Affordable Direct Pricing / Best Value ("Affordable Prices")
        'affordable_value' => waklert_content_icon('icon_library_icon_9ae8d7d126'),
    ];
}

/**
 * Determine the best matching icon preset slug based on a card's title and description.
 */
function waklert_detect_icon_preset_from_text(string $title = '', string $desc = '', string $default_preset = 'parcel_guarantee'): string {
    $t = strtolower(trim($title));
    $haystack = strtolower(trim($title . ' ' . $desc));
    if ($haystack === '') {
        return $default_preset;
    }

    // --- PHASE 1: High-priority matches on the CARD TITLE ($t) ---
    if ($t !== '') {
        if (str_contains($t, "doesn't land") || str_contains($t, "doesnt land") || str_contains($t, 'doesn’t land') || str_contains($t, 'fix it') || str_contains($t, 'reship') || str_contains($t, 'refund') || str_contains($t, 'guarantee')) {
            return 'parcel_guarantee';
        }
        if (str_contains($t, 'real people') || str_contains($t, 'on chat') || str_contains($t, 'support') || str_contains($t, 'question') || str_contains($t, 'whatsapp') || str_contains($t, 'sms')) {
            return 'live_chat_support';
        }
        if (str_contains($t, 'straight up') || str_contains($t, 'candy coating') || str_contains($t, 'schedule 4') || str_contains($t, 'prescription') || str_contains($t, 'clear boundaries') || str_contains($t, 'information first')) {
            return 'medical_rx_clarity';
        }
        if (str_contains($t, 'checkout') || str_contains($t, 'payid') || str_contains($t, 'payment') || str_contains($t, 'confirm your order')) {
            if (str_contains($t, 'delivery')) {
                return 'express_shipping';
            }
            return 'aud_checkout';
        }
        if (str_contains($t, 'returning') || str_contains($t, 'repeat') || str_contains($t, 'loyalty')) {
            return 'returning_loyalty';
        }
        if (str_contains($t, 'sealed')) {
            return 'browse_catalogue';
        }
        if (str_contains($t, 'discreet')) {
            return 'discreet_sealed';
        }
        if (str_contains($t, 'po box') || str_contains($t, 'parcel locker')) {
            return 'po_box_delivery';
        }
        if (str_contains($t, 'no customs') || str_contains($t, 'customs')) {
            return 'no_customs';
        }
        if (str_contains($t, 'affordable') || str_contains($t, 'price') || str_contains($t, 'value')) {
            return 'affordable_value';
        }
        if (str_contains($t, 'browse') || str_contains($t, 'review the range') || str_contains($t, 'focused range') || str_contains($t, 'focused product') || str_contains($t, 'our approach')) {
            return 'browse_catalogue';
        }
        if (str_contains($t, 'compare') || str_contains($t, 'listing detail') || str_contains($t, 'by listing') || str_contains($t, 'new customer')) {
            return 'listing_details';
        }
        if (str_contains($t, 'australia-wide') || str_contains($t, 'destination')) {
            return 'australia_delivery';
        }
        if (str_contains($t, 'track') || str_contains($t, 'shipping') || str_contains($t, 'delivery') || str_contains($t, 'dispatch')) {
            return 'express_shipping';
        }
    }

    // --- PHASE 2: Fallback matches on combined Title + Description ($haystack) ---
    if (
        str_contains($haystack, "doesn't land") ||
        str_contains($haystack, "doesnt land") ||
        str_contains($haystack, 'doesn’t land') ||
        str_contains($haystack, 'we fix it') ||
        str_contains($haystack, 'reship') ||
        str_contains($haystack, 'refund') ||
        str_contains($haystack, 'guarantee') ||
        str_contains($haystack, 'stalls') ||
        str_contains($haystack, 'goes missing')
    ) {
        return 'parcel_guarantee';
    }

    if (
        str_contains($haystack, 'real people') ||
        str_contains($haystack, 'on chat') ||
        str_contains($haystack, 'whatsapp') ||
        str_contains($haystack, 'sms') ||
        str_contains($haystack, '7 days a week') ||
        str_contains($haystack, '24/7')
    ) {
        return 'live_chat_support';
    }

    if (
        str_contains($haystack, 'straight up') ||
        str_contains($haystack, 'candy coating') ||
        str_contains($haystack, 'schedule 4') ||
        str_contains($haystack, 'prescription') ||
        str_contains($haystack, 'doctor') ||
        str_contains($haystack, 'pharmacist') ||
        str_contains($haystack, 'medical advice') ||
        str_contains($haystack, 'clear boundaries')
    ) {
        return 'medical_rx_clarity';
    }

    if (
        str_contains($haystack, 'aud checkout') ||
        str_contains($haystack, 'payid') ||
        str_contains($haystack, 'bank transfer') ||
        str_contains($haystack, 'secure checkout') ||
        str_contains($haystack, 'encrypted') ||
        str_contains($haystack, 'payment') ||
        str_contains($haystack, 'confirm your order') ||
        str_contains($haystack, 'pay securely')
    ) {
        return 'aud_checkout';
    }

    if (
        str_contains($haystack, 'returning customer') ||
        str_contains($haystack, 'repeat') ||
        str_contains($haystack, 'familiar with the product')
    ) {
        return 'returning_loyalty';
    }

    if (
        str_contains($haystack, 'discreet') ||
        str_contains($haystack, 'sealed') ||
        str_contains($haystack, 'unmarked') ||
        str_contains($haystack, 'plain pack') ||
        str_contains($haystack, 'blister pack')
    ) {
        return 'discreet_sealed';
    }

    if (
        str_contains($haystack, 'po box') ||
        str_contains($haystack, 'parcel locker') ||
        str_contains($haystack, 'mailbox')
    ) {
        return 'po_box_delivery';
    }

    if (
        str_contains($haystack, 'no customs') ||
        str_contains($haystack, 'customs')
    ) {
        return 'no_customs';
    }

    if (
        str_contains($haystack, 'affordable') ||
        str_contains($haystack, 'lowest price') ||
        str_contains($haystack, 'best value')
    ) {
        return 'affordable_value';
    }

    if (
        str_contains($haystack, 'listing detail') ||
        str_contains($haystack, 'compare') ||
        str_contains($haystack, 'by listing') ||
        str_contains($haystack, 'new customer') ||
        str_contains($haystack, 'stated strength')
    ) {
        return 'listing_details';
    }

    if (
        str_contains($haystack, 'focused range') ||
        str_contains($haystack, 'focused product') ||
        str_contains($haystack, 'browse') ||
        str_contains($haystack, 'review the range') ||
        str_contains($haystack, 'catalogue')
    ) {
        return 'browse_catalogue';
    }

    if (
        str_contains($haystack, 'australia-wide') ||
        str_contains($haystack, 'australian states') ||
        str_contains($haystack, 'metro and regional') ||
        str_contains($haystack, 'territories')
    ) {
        return 'australia_delivery';
    }

    if (
        str_contains($haystack, 'shipping') ||
        str_contains($haystack, 'delivery') ||
        str_contains($haystack, 'dispatch') ||
        str_contains($haystack, 'australia post') ||
        str_contains($haystack, 'track')
    ) {
        return 'express_shipping';
    }

    return $default_preset;
}

/**
 * Render an icon for any ACF card/badge/step row.
 *
 * Priority order:
 * 1. Custom uploaded image (`icon_image` array/URL/ID) -> renders `<img>`
 * 2. Explicit `icon_preset` selected in ACF (when not empty and not 'auto') -> renders preset SVG
 * 3. Custom colorful `<svg>` pasted in `icon_svg` (ignoring legacy monochrome `stroke="currentColor"` wireframes) -> renders SVG
 * 4. Smart semantic detection from `$title` + `$desc` -> renders matching colorful preset SVG
 *
 * @param array  $args {
 *   @type mixed  $icon_image      ACF image array, attachment ID, or URL.
 *   @type string $icon_preset     ACF select value (e.g. 'auto', 'parcel_guarantee', etc.).
 *   @type string $icon_svg        ACF textarea raw SVG markup.
 *   @type string $title           Card title or label for semantic matching and alt text.
 *   @type string $desc            Card description for semantic matching.
 *   @type string $default_preset  Fallback preset key if text is empty.
 *   @type string $size_class      Tailwind size classes for the SVG/img (default: 'h-11 w-11').
 * }
 * @return string HTML markup for the icon.
 */
function waklert_render_card_icon(array $args = []): string {
    $icon_image     = $args['icon_image'] ?? null;
    $icon_preset    = isset($args['icon_preset']) ? trim((string) $args['icon_preset']) : 'auto';
    $icon_svg       = isset($args['icon_svg']) ? trim((string) $args['icon_svg']) : '';
    $title          = isset($args['title']) ? trim((string) $args['title']) : '';
    $desc           = isset($args['desc']) ? trim((string) $args['desc']) : '';
    $default_preset = isset($args['default_preset']) ? trim((string) $args['default_preset']) : 'parcel_guarantee';
    $size_class     = isset($args['size_class']) ? trim((string) $args['size_class']) : 'h-11 w-11';

    // 1. Custom Uploaded Image (PNG / SVG / WebP from Flaticon, SVGRepo, etc.)
    $img_url = '';
    $img_alt = $title !== '' ? $title : 'Section Icon';
    if (is_array($icon_image) && !empty($icon_image['url'])) {
        $img_url = (string) $icon_image['url'];
        if (!empty($icon_image['alt'])) {
            $img_alt = (string) $icon_image['alt'];
        }
    } elseif (is_numeric($icon_image) && (int) $icon_image > 0) {
        $resolved = wp_get_attachment_image_url((int) $icon_image, 'full');
        if ($resolved) {
            $img_url = $resolved;
        }
    } elseif (is_string($icon_image) && filter_var($icon_image, FILTER_VALIDATE_URL)) {
        $img_url = $icon_image;
    }

    if ($img_url !== '') {
        return sprintf(
            '<img src="%s" alt="%s" class="%s object-contain select-none" loading="lazy" decoding="async" />',
            esc_url($img_url),
            esc_attr($img_alt),
            esc_attr($size_class)
        );
    }

    $library = waklert_get_colorful_icon_svgs();

    // 2. Explicit Preset Chosen in WP Admin (not 'auto')
    if ($icon_preset !== '' && $icon_preset !== 'auto' && isset($library[$icon_preset])) {
        return str_replace('class="h-11 w-11"', 'class="' . esc_attr($size_class) . '"', $library[$icon_preset]);
    }

    // 3. Custom SVG code, including monochrome artwork, when the preset is Auto.
    if (
        $icon_svg !== '' &&
        stripos($icon_svg, '<svg') !== false
    ) {
        return waklert_sanitize_content_svg($icon_svg);
    }

    // 4. Smart Semantic Match from Title + Description
    $matched_key = waklert_detect_icon_preset_from_text($title, $desc, $default_preset);
    $svg = $library[$matched_key] ?? $library['parcel_guarantee'];

    return str_replace('class="h-11 w-11"', 'class="' . esc_attr($size_class) . '"', $svg);
}
