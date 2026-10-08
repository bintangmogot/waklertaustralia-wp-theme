<?php
/**
 * Module: Contact Form & Info
 */

$heading = get_sub_field('heading') ?: "Have Questions? We Are Here.";

$desc = get_sub_field('description') ?: "Our team speaks English and Australia. We usually reply within 30 minutes during business hours.";

$whatsapp = get_field('whatsapp_number', 'option') ?: 'https://wa.me/60185754182';
$email = get_field('contact_email', 'option') ?: 'orders@modafinil-australia.com';
?>
<section class="bg-background pt-8 pb-4 md:pt-16 md:pb-8 text-center">
    <div class="container-site max-w-3xl">
        <span class="inline-block rounded-full bg-primary-softer px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-primary">
            <?= "Contact Us" ?>
        </span>
        <h1 class="mt-4 font-heading text-3xl sm:text-4xl font-extrabold tracking-tight md:text-5xl">
            <?= $heading ?>
        </h1>
        <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-muted-foreground">
            <?= $desc ?>
        </p>
    </div>
</section>

<section class="pb-8 pt-4 md:pb-16 md:pt-8 bg-background">
    <div class="container-site grid gap-12 lg:grid-cols-[1fr_1.2fr]">
        <div class="space-y-6">
            <a href="<?= esc_url($whatsapp) ?>" target="_blank" rel="noopener noreferrer" class="flex gap-4 rounded-xl border border-primary/20 bg-primary-softer/30 p-5 shadow-sm transition-all hover:border-primary/50 hover:bg-primary-softer/50">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-primary text-primary-foreground">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 shrink-0"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.67-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                </span>
                <div>
                    <h2 class="font-heading text-base font-bold text-foreground"><?= "WhatsApp (Fastest Option)" ?></h2>
                    <p class="mt-1 text-sm leading-relaxed text-muted-foreground">+60 18-575 4182</p>
                </div>
            </a>

            <a href="<?= esc_url('mailto:' . $email) ?>" class="flex gap-4 rounded-xl border border-border bg-card p-5 shadow-card">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-primary-softer text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                </span>
                <div>
                    <h2 class="font-heading text-base font-bold"><?= "Email" ?></h2>
                    <p class="mt-1 text-sm leading-relaxed text-muted-foreground"><?= esc_html($email) ?> &middot; <?= "Within 24 hours" ?></p>
                </div>
            </a>

            <div class="rounded-xl border border-border bg-muted/30 p-5">
                <h2 class="font-heading text-sm font-bold uppercase tracking-wider text-foreground"><?= "OPERATING HOURS" ?></h2>
                <div class="mt-5 flex flex-col gap-3 text-sm text-muted-foreground">
                    <div class="flex justify-between gap-4">
                        <span><?= "Monday - Friday" ?></span>
                        <span class="font-medium text-foreground text-right">9:00 AM &ndash; 8:00 PM MYT</span>
                    </div>
                    <div class="flex justify-between gap-4">
                        <span><?= "Saturday" ?></span>
                        <span class="font-medium text-foreground text-right">10:00 AM &ndash; 5:00 PM MYT</span>
                    </div>
                    <div class="flex justify-between gap-4">
                        <span><?= "Sunday / Public Holiday" ?></span>
                        <span class="font-medium text-foreground text-right"><?= "Limited (WhatsApp only)" ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-border bg-card p-7 shadow-card">
            <?= do_shortcode('[gravityform id="1" title="true" ajax="true"]') ?>
        </div>
    </div>
</section>
