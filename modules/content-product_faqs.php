<?php
/**
 * Module: FAQs
 */

if (waklert_module_is_empty()) { return; }

$heading = waklert_content('content_product_faqs_text_d537212157');
?>
<section class="section-padding bg-white" data-testid="faq-strip">
    <div class="container-custom max-w-3xl">
        <?php if ((waklert_has_content($heading))): ?><div class="text-center mb-10">
            <?php if (waklert_has_content($heading)): ?><h2 class="font-heading text-2xl md:text-4xl font-black text-ink mb-3">
                <?= $heading ?>
            </h2><?php endif; ?>
        </div><?php endif; ?>

        <div class="space-y-4">
            <?php 
            if(have_rows('faq_items')): 
                while(have_rows('faq_items')): the_row();
        if (!waklert_has_content(get_sub_field('question'))) { continue; }
            ?>
            <details open class="group border border-stone-200 rounded-xl transition-all duration-200 hover:-translate-y-0.5 hover:border-primary/40 hover:shadow-md open:bg-primary-softer/50 open:border-primary/40">
                <summary class="flex items-center justify-between gap-4 p-5 cursor-pointer list-none rounded-xl transition-colors hover:text-primary-dark active:bg-primary-softer/60">
                    <?php if (waklert_has_content(get_sub_field('question'))): ?><h3 class="font-heading font-bold text-ink text-sm">
                        <?= get_sub_field('question') ?>
                    </h3><?php endif; ?>
                    <?= waklert_content_icon('content_product_faqs_icon_edcde894c1') ?>
                </summary>
                <?php if (waklert_has_content(wp_kses_post(wpautop(get_sub_field('answer'))))): ?><div class="px-5 pb-5 text-sm text-muted-foreground leading-relaxed border-t border-stone-100 pt-4 prose prose-sm max-w-none [&_a]:text-primary [&_a]:underline [&_a]:font-semibold hover:[&_a]:text-primary-dark">
                    <?= wp_kses_post(wpautop(get_sub_field('answer'))) ?>
                </div><?php endif; ?>
            </details>
            <?php 
                endwhile;
            else:
                // Fallback default FAQs
                $defaults = [];
                foreach($defaults as $f):
            ?>
            <details open class="group border border-stone-200 rounded-xl transition-all duration-200 hover:-translate-y-0.5 hover:border-primary/40 hover:shadow-md open:bg-primary-softer/50 open:border-primary/40">
                <summary class="flex items-center justify-between gap-4 p-5 cursor-pointer list-none rounded-xl transition-colors hover:text-primary-dark active:bg-primary-softer/60">
                    <?php if (waklert_has_content($f['question'])): ?><h3 class="font-heading font-bold text-ink text-sm">
                        <?= $f['question'] ?>
                    </h3><?php endif; ?>
                    <?= waklert_content_icon('content_product_faqs_icon_edcde894c1') ?>
                </summary>
                <?php if (waklert_has_content(wp_kses_post(wpautop($f['answer'])))): ?><div class="px-5 pb-5 text-sm text-muted-foreground leading-relaxed border-t border-stone-100 pt-4 prose prose-sm max-w-none [&_a]:text-primary [&_a]:underline [&_a]:font-semibold hover:[&_a]:text-primary-dark">
                    <?= wp_kses_post(wpautop($f['answer'])) ?>
                </div><?php endif; ?>
            </details>
            <?php 
                endforeach;
            endif; 
            ?>
        </div>

    </div>
</section>
