<?php
/**
 * Module: Comparison Table
 */

// The cloned comparison contained unsupported medical and dependency claims.
// Currently re-enabled per user request.

$tag = get_sub_field('tag') ?: "Comparison";

$heading = get_sub_field('heading') ?: "Waklert vs Coffee vs Energy Drinks";

$desc = get_sub_field('description') ?: "See why thousands of Australian workers choose Waklert over caffeine.";
?>
<section class="section-padding bg-white" data-testid="comparison-table">
    <div class="container-custom max-w-4xl">
        <div class="text-center mb-10">
            <span class="inline-block bg-primary-soft text-primary-dark text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-full mb-4">
                <?= $tag ?>
            </span>
            <h2 class="font-heading text-2xl md:text-4xl font-black text-ink mb-3">
                <?= $heading ?>
            </h2>
            <p class="text-muted-foreground">
                <?= $desc ?>
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-[#0C4161] text-white">
                        <th class="text-left py-4 px-4 font-heading font-bold text-white rounded-tl-xl">
                            <?= "Feature" ?>
                        </th>
                        <th class="text-center py-4 px-4 font-heading font-bold text-white bg-[#082C42]">Waklert</th>
                        <th class="text-center py-4 px-4 font-heading font-bold text-white">
                            <?= "Coffee" ?>
                        </th>
                        <th class="text-center py-4 px-4 font-heading font-bold text-white rounded-tr-xl">
                            <?= "Energy Drink" ?>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    <?php 
                    if(have_rows('rows')): 
                        while(have_rows('rows')): the_row();
                    ?>
                    <tr>
                        <td class="py-3.5 px-4 font-medium text-foreground"><?= get_sub_field('feature') ?></td>
                        <td class="py-3.5 px-4 text-center bg-surface font-semibold text-foreground"><?= get_sub_field('modafinil') ?></td>
                        <td class="py-3.5 px-4 text-center text-muted-foreground"><?= get_sub_field('coffee') ?></td>
                        <td class="py-3.5 px-4 text-center text-muted-foreground"><?= get_sub_field('energy') ?></td>
                    </tr>
                    <?php 
                        endwhile;
                    else: 
                        // Fallback data
                        $default_rows = [
                            ['Effect Duration', 'Tempoh kesan', '10-15 jam', '10-15 hours', '2-4 jam', '2-4 hours', '1-3 jam', '1-3 hours'],
                            ['Crash Effect', 'Kesan limpahan / crash', 'Tiada', 'None', 'Sederhana', 'Moderate', 'Teruk', 'Severe']
                        ];
                        foreach($default_rows as $r):
                    ?>
                    <tr>
                        <td class="py-3.5 px-4 font-medium text-foreground"><?= $r[0] ?></td>
                        <td class="py-3.5 px-4 text-center bg-surface font-semibold text-foreground"><?= $r[3] ?></td>
                        <td class="py-3.5 px-4 text-center text-muted-foreground"><?= $r[5] ?></td>
                        <td class="py-3.5 px-4 text-center text-muted-foreground"><?= $r[7] ?></td>
                    </tr>
                    <?php 
                        endforeach;
                    endif; 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

