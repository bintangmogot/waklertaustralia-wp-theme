<?php
/**
 * Module: Inline support CTA
 */

$title = get_sub_field('title') ?: 'Need Order Support?';
$description = get_sub_field('desc') ?: 'Questions about products, checkout or an order? Contact our support team.';
$chat_label = get_sub_field('chat_btn_text') ?: 'WhatsApp Support';
$chat_url = trim((string) get_sub_field('chat_btn_url'));
$contact_label = get_sub_field('email_btn_text') ?: 'Contact Us';
$contact_url = trim((string) get_sub_field('email_btn_url'));

if ($chat_url === '') {
    $whatsapp_value = (string) get_field('whatsapp_number', 'option');
    $phone = preg_replace('/\D+/', '', $whatsapp_value);
    $chat_url = $phone !== ''
        ? 'https://api.whatsapp.com/send?phone=' . $phone
        : home_url('/contact/');
} elseif (preg_match('#^https?://wa\.me/#i', $chat_url)) {
    $chat_url = preg_replace('#^https?://wa\.me/#i', 'https://api.whatsapp.com/send?phone=', $chat_url);
}

if ($contact_url === '') {
    $email = sanitize_email((string) get_field('footer_email', 'option'));
    $contact_url = $email !== '' ? 'mailto:' . $email : home_url('/contact/');
}
?>
<section class="section-padding bg-background" data-testid="support-cta">
    <div class="container-site max-w-6xl">
        <div class="flex flex-wrap items-center gap-5 rounded-2xl border border-primary/20 bg-primary-softer p-6 shadow-sm transition-colors hover:border-primary/40 md:p-8">
            <div class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-primary text-primary-foreground shadow-sm" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 11.5a8.5 8.5 0 0 1-12.8 7.3L3 20l1.2-4.8A8.5 8.5 0 1 1 21 11.5Z" />
                </svg>
            </div>
            <div class="min-w-[220px] flex-1">
                <h2 class="font-heading text-xl font-bold text-ink"><?= esc_html($title) ?></h2>
                <p class="mt-1 text-sm leading-relaxed text-muted-foreground"><?= esc_html($description) ?></p>
            </div>
            <?php if ($chat_label !== ''): ?>
            <a href="<?= esc_url($chat_url) ?>" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-lg bg-primary px-5 py-3 text-sm font-bold text-primary-foreground transition-colors hover:bg-primary-dark focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                <?= esc_html($chat_label) ?>
            </a>
            <?php endif; ?>
            <?php if ($contact_label !== ''): ?>
            <a href="<?= esc_url($contact_url) ?>" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-lg border border-primary/40 px-5 py-3 text-sm font-bold text-primary-dark transition-colors hover:border-accent hover:bg-accent hover:text-ink focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                <?= esc_html($contact_label) ?>
            </a>
            <?php endif; ?>
        </div>
    </div>
</section>
