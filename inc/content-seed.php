<?php
/**
 * Content seed: puts the default FAQ questions into the FAQs modules as real WP Admin content
 * (Pages -> Modules -> FAQs -> FAQ Items), so what visitors read is what the client can edit.
 *
 * Runs once per environment. Bump WAKLERT_CONTENT_SEED_VERSION whenever the defaults change.
 * A FAQs module that already has at least one written question is never touched.
 */

const WAKLERT_CONTENT_SEED_VERSION = '20261102_faq_seed_v2';

/** True when any row of this FAQs module already has a question typed in. */
function waklert_faq_module_has_content($post_id, $idx) {
    $count = (int) get_post_meta($post_id, "modules_{$idx}_faq_items", true);
    for ($r = 0; $r < $count; $r++) {
        if (trim((string) get_post_meta($post_id, "modules_{$idx}_faq_items_{$r}_question", true)) !== '') {
            return true;
        }
    }
    return false;
}

/** Writes the default FAQs into one FAQs module, replacing any empty rows left behind. */
function waklert_seed_faq_module($post_id, $idx) {
    global $wpdb;

    $like = $wpdb->esc_like("modules_{$idx}_faq_items_") . '%';
    $wpdb->query($wpdb->prepare(
        "DELETE FROM {$wpdb->postmeta} WHERE post_id = %d AND (meta_key LIKE %s OR meta_key LIKE %s)",
        $post_id,
        $like,
        '\_' . $like
    ));

    $items = waklert_default_faq_items();
    foreach ($items as $r => $row) {
        update_post_meta($post_id, "modules_{$idx}_faq_items_{$r}_question", $row['question']);
        update_post_meta($post_id, "_modules_{$idx}_faq_items_{$r}_question", 'field_faq_q_en');
        update_post_meta($post_id, "modules_{$idx}_faq_items_{$r}_answer", '<p>' . $row['answer'] . '</p>');
        update_post_meta($post_id, "_modules_{$idx}_faq_items_{$r}_answer", 'field_faq_a_en');
    }
    update_post_meta($post_id, "modules_{$idx}_faq_items", count($items));
    update_post_meta($post_id, "_modules_{$idx}_faq_items", 'field_faq_items');
}

add_action('init', function() {
    if (get_option('waklert_content_seed_version') === WAKLERT_CONTENT_SEED_VERSION) {
        return;
    }

    $post_ids = get_posts([
        'post_type'      => 'any',
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'meta_key'       => 'modules',
    ]);
    foreach ($post_ids as $post_id) {
        $layouts = get_post_meta($post_id, 'modules', true);
        if (!is_array($layouts)) {
            continue;
        }
        foreach ($layouts as $idx => $layout_name) {
            if ($layout_name === 'faqs' && !waklert_faq_module_has_content($post_id, $idx)) {
                waklert_seed_faq_module($post_id, $idx);
            }
        }
    }

    update_option('waklert_content_seed_version', WAKLERT_CONTENT_SEED_VERSION);
    do_action('litespeed_purge_all');
}, 99);
