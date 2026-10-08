<?php
/**
 * Module: How to Order (Steps)
 */

$tag = get_sub_field('tag') ?: "Simple Process";

$heading = get_sub_field('heading') ?: "Three Steps to Better Focus";

$is_about_page = is_page('about-us');
$section_classes = $is_about_page ? 'relative isolate overflow-hidden section-padding bg-primary-dark' : 'section-padding bg-white';
$tag_classes = $is_about_page
    ? 'inline-block bg-primary-soft text-accent text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-full mb-4'
    : 'inline-block bg-primary-soft text-primary-dark text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-full mb-4';
?>
<section class="<?= esc_attr($section_classes) ?>" data-testid="<?= $is_about_page ? 'about-site-guide' : 'how-it-works' ?>">
    <?php if ($is_about_page) waklert_output_pattern_rings(); ?>
    <div class="container-site <?= $is_about_page ? 'relative z-10' : '' ?>">
        <div class="text-center mb-12">
            <span class="<?= esc_attr($tag_classes) ?>">
                <?= $tag ?>
            </span>
            <h2 class="font-heading text-2xl md:text-4xl font-black <?= $is_about_page ? 'text-white' : 'text-ink' ?>">
                <?= $heading ?>
            </h2>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8 max-w-4xl mx-auto">
            <?php 
            if(have_rows('steps')): 
                $count = 1;
                while(have_rows('steps')): the_row(); 
            ?>
            <div class="text-center">
                <div class="w-16 h-16 rounded-2xl <?= $is_about_page ? 'bg-accent text-primary-dark' : 'bg-primary-softer border-2 border-primary-soft text-primary' ?> flex items-center justify-center mx-auto mb-5">
                    <?php 
                    $icon = get_sub_field('icon_svg');
                    if($icon) echo $icon; 
                    ?>
                </div>
                <span class="<?= $is_about_page ? 'text-accent' : 'text-primary' ?> font-black text-sm tracking-widest">0<?= $count ?></span>
                <h3 class="font-heading font-bold text-lg <?= $is_about_page ? 'text-white' : 'text-ink' ?> mt-1 mb-2"><?= get_sub_field('title') ?></h3>
                <p class="<?= $is_about_page ? 'text-white' : 'text-muted-foreground' ?> text-sm leading-relaxed">
                    <?= get_sub_field('desc') ?>
                </p>
            </div>
            <?php 
                $count++;
                endwhile; 
            else: 
            ?>
            <!-- Default Fallback Steps if ACF empty -->
            <div class="text-center">
                <div class="w-16 h-16 rounded-2xl bg-primary-softer border-2 border-primary-soft flex items-center justify-center mx-auto mb-5 text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                </div>
                <span class="text-primary font-black text-sm tracking-widest">01</span>
                <h3 class="font-heading font-bold text-lg text-ink mt-1 mb-2"><?= "Choose Your Product" ?></h3>
                <p class="text-muted-foreground text-sm leading-relaxed">
                    <?= "Browse our selection of Modafinil & Armodafinil. Select quantity — larger orders save more." ?>
                </p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 rounded-2xl bg-primary-softer border-2 border-primary-soft flex items-center justify-center mx-auto mb-5 text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" /></svg>
                </div>
                <span class="text-primary font-black text-sm tracking-widest">02</span>
                <h3 class="font-heading font-bold text-lg text-ink mt-1 mb-2"><?= "Pay via Bank Transfer" ?></h3>
                <p class="text-muted-foreground text-sm leading-relaxed">
                    <?= "Secure FPX payment or bank transfer — no card details needed. Processed within hours." ?>
                </p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 rounded-2xl bg-primary-softer border-2 border-primary-soft flex items-center justify-center mx-auto mb-5 text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" /></svg>
                </div>
                <span class="text-primary font-black text-sm tracking-widest">03</span>
                <h3 class="font-heading font-bold text-lg text-ink mt-1 mb-2"><?= "Delivered to Your Door" ?></h3>
                <p class="text-muted-foreground text-sm leading-relaxed">
                    <?= "Shipped via Australia Post in discreet packaging. Track your order online. 7-14 days to all of Australia." ?>
                </p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
