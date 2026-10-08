<?php
/**
 * Module: Why Choose Us (Audiences)
 */

$tag = get_sub_field('tag') ?: "Made for Australia";

$heading = get_sub_field('heading') ?: "Who Uses Modafinil in Australia?";

$desc = get_sub_field('description') ?: "From UNSW students in Sydney to Monash doctors in Melbourne, thousands of Australians use Modafinil to stay sharp when it matters most.";

$is_about_page = is_page('about-us');
$section_classes = $is_about_page ? 'relative isolate overflow-hidden section-padding bg-primary-dark' : 'section-padding bg-stone-50';
$tag_classes = $is_about_page
    ? 'inline-block bg-primary-soft text-accent text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-full mb-4'
    : 'inline-block bg-primary-soft text-primary-dark text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-full mb-4';
?>
<section class="<?= esc_attr($section_classes) ?>" data-testid="<?= $is_about_page ? 'about-principles' : 'australia-identity' ?>">
    <?php if ($is_about_page) waklert_output_pattern_rings(); ?>
    <div class="container-custom <?= $is_about_page ? 'relative z-10' : '' ?>">
        <div class="text-center mb-12">
            <span class="<?= esc_attr($tag_classes) ?>">
                <?= $tag ?>
            </span>
            <h2 class="font-heading text-2xl md:text-4xl font-black <?= $is_about_page ? 'text-white' : 'text-ink' ?> mb-3">
                <?= $heading ?>
            </h2>
            <p class="<?= $is_about_page ? 'text-white' : 'text-muted-foreground' ?> max-w-2xl mx-auto">
                <?= $desc ?>
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <?php if(have_rows('audiences')): ?>
                <?php while(have_rows('audiences')): the_row(); ?>
                <div class="bg-white border border-stone-200 rounded-xl p-6 <?= $is_about_page ? 'hover:border-accent' : 'hover:border-primary' ?> hover:shadow-md transition-all">
                    <div class="w-12 h-12 rounded-xl <?= $is_about_page ? 'bg-accent text-primary-dark' : 'bg-primary-softer text-primary-dark' ?> flex items-center justify-center mb-4">
                        <?= get_sub_field('icon_svg') ?>
                    </div>
                    <h3 class="font-heading font-bold text-ink mb-2">
                        <?= get_sub_field('title') ?>
                    </h3>
                    <p class="text-sm text-muted-foreground leading-relaxed">
                        <?= get_sub_field('desc') ?>
                    </p>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <!-- Default audiences fallback -->
                <div class="bg-white border border-stone-200 rounded-xl p-6 hover:border-primary-soft hover:shadow-md transition-all">
                    <div class="w-12 h-12 rounded-xl bg-primary-softer text-primary-dark flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" /></svg>
                    </div>
                    <h3 class="font-heading font-bold text-ink mb-2"><?= "University Students" ?></h3>
                    <p class="text-sm text-muted-foreground leading-relaxed">
                        <?= "Exams, thesis, and final assignments. UM, UTM, UiTM, Sunway, Monash — get the focus you need without burnout." ?>
                    </p>
                </div>
                <!-- Adding more is tedious, we rely on ACF fields normally -->
            <?php endif; ?>
        </div>
    </div>
</section>
