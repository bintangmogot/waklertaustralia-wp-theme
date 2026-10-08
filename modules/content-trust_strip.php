<?php
/**
 * Module: Trust Strip (4 Icons below Hero)
 */

?>
<section class="bg-white border-y border-stone-100" data-testid="trust-badges">
    <div class="container-custom py-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <?php 
            if(have_rows('badges')): 
                while(have_rows('badges')): the_row();
            ?>
            <div class="flex flex-col items-center text-center gap-2 px-3 py-4 rounded-xl text-stone-700">
                <div class="text-primary">
                    <?= get_sub_field('icon_svg') ?>
                </div>
                <p class="text-xs font-bold uppercase tracking-wider leading-tight">
                    <?= get_sub_field('label') ?>
                </p>
            </div>
            <?php 
                endwhile;
            else: 
            ?>
            <!-- Default badges -->
            <div class="flex flex-col items-center text-center gap-2 px-3 py-4 rounded-xl text-stone-700">
                <div class="text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" /></svg>
                </div>
                <p class="text-xs font-bold uppercase tracking-wider leading-tight">
                    <?= "Australia Post Delivery" ?>
                </p>
            </div>
            <div class="flex flex-col items-center text-center gap-2 px-3 py-4 rounded-xl text-stone-700">
                <div class="text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" /></svg>
                </div>
                <p class="text-xs font-bold uppercase tracking-wider leading-tight">
                    <?= "100% Genuine Pharmacy Grade" ?>
                </p>
            </div>
            <div class="flex flex-col items-center text-center gap-2 px-3 py-4 rounded-xl text-stone-700">
                <div class="text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" /></svg>
                </div>
                <p class="text-xs font-bold uppercase tracking-wider leading-tight">
                    <?= "Secure Local Bank Transfer" ?>
                </p>
            </div>
            <div class="flex flex-col items-center text-center gap-2 px-3 py-4 rounded-xl text-stone-700">
                <div class="text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                </div>
                <p class="text-xs font-bold uppercase tracking-wider leading-tight">
                    <?= "Discreet Plain Packaging" ?>
                </p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
