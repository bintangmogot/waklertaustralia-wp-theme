<?php
/**
 * Template Name: Track Order
 * Description: Dedicated Australia Post Order Tracking page for Waklert Australia.
 */

get_header();

// Optional prefilled tracking number from query string
$tracking_param = isset($_GET['tracking']) ? sanitize_text_field(wp_unslash($_GET['tracking'])) : '';
if (!$tracking_param && isset($_GET['order_id'])) {
    $tracking_param = sanitize_text_field(wp_unslash($_GET['order_id']));
}

$site_name = get_bloginfo('name') ?: 'Waklert Australia';
$shop_url  = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
$contact_url = home_url('/contact/');
$shipping_url = home_url('/shipping-policy/');
$auspost_logo_url = get_theme_file_uri('/assets/images/australia-post.png');
?>

<main id="main-content" class="site-main bg-white">
    <!-- Breadcrumb & Header Section -->
    <header class="relative overflow-hidden border-b-2 border-dashed border-sky-300/80 bg-gradient-to-b from-[#f0f6fa] via-[#eef5fa] to-white bg-pattern-dots text-center py-6 sm:py-7 md:py-9" data-testid="track-order-hero">
        <div class="container-site max-w-5xl mx-auto px-4 relative z-10">
            <!-- Breadcrumbs -->
            <div class="mb-3">
                <nav aria-label="Breadcrumb" class="inline-flex max-w-full flex-wrap items-center justify-center gap-1.5 rounded-full border border-dashed border-sky-300/80 bg-white/90 px-3.5 py-1 text-xs font-medium text-slate-500 shadow-xs backdrop-blur">
                    <a href="<?= esc_url(home_url('/')) ?>" class="font-bold text-slate-600 transition-colors hover:text-[#0c4161]">Home</a>
                    <span class="text-sky-300 font-normal">/</span>
                    <span aria-current="page" class="font-extrabold text-[#0c4161]">Order Tracking</span>
                </nav>
            </div>

            <!-- Eyebrow Badge -->
            <div class="mb-2.5">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3.5 py-1 text-xs font-black uppercase tracking-[0.16em] text-[#0c4161] shadow-xs">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse" aria-hidden="true"></span>
                    Live Australia Post Tracking
                </span>
            </div>

            <h1 class="mx-auto max-w-3xl font-heading text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black leading-tight tracking-tight text-[#0c4161]">
                Track Your Parcel
            </h1>
            <p class="mx-auto mt-3 max-w-2xl text-sm md:text-base leading-relaxed text-slate-600">
                Follow your Waklert Australia delivery from our warehouse to your doorstep with real-time Australia Post tracking.
            </p>
        </div>
    </header>

    <!-- Main Content Area -->
    <div class="container-site max-w-5xl mx-auto px-4 py-6 sm:py-8 space-y-7 sm:space-y-9">

        <!-- Intro Callout Box (Yellow/Amber Accent Line) -->
        <div class="rounded-2xl border border-slate-200/90 border-l-[6px] border-l-amber-500 bg-gradient-to-r from-amber-50/40 via-white to-white p-5 sm:p-7 shadow-xs">
            <p class="text-sm sm:text-base leading-relaxed text-slate-700 m-0">
                Welcome to the <strong>Waklert Australia</strong> order tracking page. Every parcel we dispatch is shipped with <a href="https://auspost.com.au/" target="_blank" rel="noopener noreferrer" class="font-bold text-[#0c4161] underline hover:text-amber-600 transition-colors">Australia Post</a> and comes with a unique tracking number, so you can follow your delivery from our warehouse to your door.
            </p>
            <p class="mt-3 text-sm sm:text-base leading-relaxed text-slate-700 m-0">
                Your tracking number was emailed to you when your order was dispatched. Enter it below and we'll take you straight to the live Australia Post tracking results for your parcel.
            </p>
        </div>

        <!-- 2-Column Main Tracker & Companion Banner Section -->
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-stretch" aria-label="Tracking Tool and Information">
            
            <!-- Left Column: Tracking Form & Keywords -->
            <div class="lg:col-span-7 xl:col-span-7 flex flex-col justify-between space-y-6">
                <div>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-[#0c4161] tracking-tight">
                        Enter Your Tracking Number
                    </h2>
                    <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Tracking numbers are usually 10–23 characters long, e.g. <code class="rounded bg-slate-100 px-1.5 py-0.5 font-mono font-bold text-slate-800 border border-slate-200">33ABC1234567</code>. You can find yours in your dispatch confirmation email.
                    </p>

                    <!-- Interactive Tracking Form -->
                    <form id="auspost-tracking-form" action="https://auspost.com.au/mypost/track/search" method="GET" target="_blank" rel="noopener noreferrer" class="mt-5 space-y-3">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <div class="relative flex-1">
                                <label for="auspost-tracking-input" class="sr-only">Enter Australia Post Tracking Number</label>
                                <input 
                                    type="text" 
                                    id="auspost-tracking-input" 
                                    name="id" 
                                    value="<?= esc_attr($tracking_param) ?>" 
                                    placeholder="e.g. 33ABC1234567" 
                                    autocomplete="off"
                                    spellcheck="false"
                                    required
                                    class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 sm:py-3.5 text-base sm:text-lg font-mono tracking-wider text-slate-900 placeholder:text-slate-400 focus:border-[#0c4161] focus:bg-white focus:outline-none focus:ring-4 focus:ring-sky-100 transition-all shadow-inner"
                                >
                            </div>
                            <button 
                                type="submit" 
                                id="auspost-tracking-btn"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 active:scale-[0.98] text-white px-6 sm:px-7 py-3 sm:py-3.5 text-sm sm:text-base font-black uppercase tracking-wider shadow-md hover:shadow-lg hover:shadow-amber-500/20 transition-all shrink-0 cursor-pointer"
                            >
                                <span>Track My Order</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                        <div id="tracking-error-msg" class="hidden text-xs font-semibold text-rose-600 pl-1" role="alert"></div>
                    </form>

                    <!-- Info Alert Box (Soft Yellow/Amber) -->
                    <div class="mt-4 rounded-xl border border-amber-200/90 bg-amber-50/70 p-4 flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed m-0">
                            You'll be redirected to the official Australia Post tracking page (<a href="https://auspost.com.au/" target="_blank" rel="noopener noreferrer" class="font-bold underline text-[#0c4161] hover:text-amber-700">auspost.com.au</a>), where your parcel's latest scan events are shown automatically.
                        </p>
                    </div>
                </div>

                <!-- Keyword / Quick Navigation Pills -->
                <div class="pt-2">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2.5">Popular Searches & Quick Links</p>
                    <div class="flex flex-wrap gap-2 sm:gap-2.5">
                        <a href="#auspost-tracking-form" class="inline-flex items-center rounded-full border border-amber-200/90 bg-amber-50/70 hover:bg-amber-100/90 text-slate-700 hover:text-slate-900 px-3.5 py-1.5 text-xs font-bold transition-all shadow-2xs">
                            Order Tracking
                        </a>
                        <a href="https://auspost.com.au/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 rounded-full border border-amber-200/90 bg-amber-50/70 hover:bg-amber-100/90 text-slate-700 hover:text-slate-900 px-3.5 py-1.5 text-xs font-bold transition-all shadow-2xs">
                            <span>Australia Post</span>
                            <svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                        <a href="<?= esc_url($shop_url) ?>" class="inline-flex items-center rounded-full border border-amber-200/90 bg-amber-50/70 hover:bg-amber-100/90 text-slate-700 hover:text-slate-900 px-3.5 py-1.5 text-xs font-bold transition-all shadow-2xs">
                            Buy Modafinil Australia
                        </a>
                        <a href="<?= esc_url($shipping_url) ?>" class="inline-flex items-center rounded-full border border-amber-200/90 bg-amber-50/70 hover:bg-amber-100/90 text-slate-700 hover:text-slate-900 px-3.5 py-1.5 text-xs font-bold transition-all shadow-2xs">
                            Shipping Australia
                        </a>
                        <a href="<?= esc_url(home_url('/product/waklert-150mg-2/')) ?>" class="inline-flex items-center rounded-full border border-amber-200/90 bg-amber-50/70 hover:bg-amber-100/90 text-slate-700 hover:text-slate-900 px-3.5 py-1.5 text-xs font-bold transition-all shadow-2xs">
                            Buy Modvigil Online
                        </a>
                        <a href="<?= esc_url(home_url('/product/artvigil-150mg/')) ?>" class="inline-flex items-center rounded-full border border-amber-200/90 bg-amber-50/70 hover:bg-amber-100/90 text-slate-700 hover:text-slate-900 px-3.5 py-1.5 text-xs font-bold transition-all shadow-2xs">
                            Buy Artvigil
                        </a>
                        <a href="<?= esc_url(home_url('/')) ?>" class="inline-flex items-center rounded-full border border-amber-200/90 bg-amber-50/70 hover:bg-amber-100/90 text-slate-700 hover:text-slate-900 px-3.5 py-1.5 text-xs font-bold transition-all shadow-2xs">
                            Waklert Australia
                        </a>
                        <a href="<?= esc_url(home_url('/armodafinil-guide/')) ?>" class="inline-flex items-center rounded-full border border-amber-200/90 bg-amber-50/70 hover:bg-amber-100/90 text-slate-700 hover:text-slate-900 px-3.5 py-1.5 text-xs font-bold transition-all shadow-2xs">
                            Modafinil Buy Australia
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column: Visual Companion Banner -->
            <div class="lg:col-span-5 xl:col-span-5 flex">
                <div class="w-full rounded-3xl border-2 border-dashed border-sky-300/80 bg-gradient-to-b from-[#eef7fd] via-[#f7fbfe] to-white p-6 sm:p-7 shadow-sm flex flex-col justify-between items-center text-center relative overflow-hidden group hover:shadow-md transition-all">
                    
                    <!-- Background Map Watermark SVG -->
                    <div class="absolute -right-6 -bottom-6 w-56 h-56 opacity-10 pointer-events-none text-sky-700" aria-hidden="true">
                        <svg viewBox="0 0 200 160" fill="currentColor">
                            <path d="M165,115 C155,120 145,135 130,135 C115,135 110,145 95,140 C80,135 70,120 60,110 C50,100 35,90 30,75 C25,60 30,45 45,35 C60,25 80,30 95,20 C110,10 135,15 150,30 C165,45 175,70 175,85 C175,100 175,110 165,115 Z"/>
                        </svg>
                    </div>

                    <!-- Top Australia Post & Brand Header -->
                    <div class="w-full flex items-center justify-between gap-3 pb-3 border-b border-sky-200/60 relative z-10">
                        <div class="flex items-center gap-2">
                            <img src="<?= esc_url($auspost_logo_url) ?>" alt="Australia Post" class="h-6 sm:h-7 w-auto object-contain">
                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-rose-700">Official Partner</span>
                        </div>
                        <span class="inline-flex items-center gap-1 rounded-full bg-sky-100 border border-sky-300/80 px-2.5 py-0.5 text-[10px] font-black uppercase tracking-wider text-[#0c4161]">
                            Waklert Australia
                        </span>
                    </div>

                    <!-- Hero Callout Heading -->
                    <div class="my-4 relative z-10">
                        <p class="font-heading text-xs font-black uppercase tracking-[0.2em] text-slate-500 mb-1">Direct Express Delivery</p>
                        <h3 class="font-heading text-2xl sm:text-3xl font-black text-slate-900 leading-tight">
                            JUST STAY AT HOME
                        </h3>
                        <p class="font-heading text-2xl sm:text-3xl font-black text-sky-600 tracking-tight leading-tight">
                            WE DELIVER!
                        </p>
                    </div>

                    <!-- Visual Illustration (Courier & Scooter/Van with 100% Safe Badge) -->
                    <div class="relative my-3 w-full max-w-[240px] flex items-center justify-center">
                        <!-- Courier Scooter Illustration SVG -->
                        <svg viewBox="0 0 200 150" class="w-full h-auto drop-shadow-md" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Road ground line -->
                            <path d="M10 135H190" stroke="#CBD5E1" stroke-width="3" stroke-linecap="round" stroke-dasharray="6 6"/>
                            <!-- Rear Wheel -->
                            <circle cx="50" cy="115" r="18" fill="#1E293B" stroke="#64748B" stroke-width="4"/>
                            <circle cx="50" cy="115" r="8" fill="#94A3B8"/>
                            <circle cx="50" cy="115" r="3" fill="#FFFFFF"/>
                            <!-- Front Wheel -->
                            <circle cx="150" cy="115" r="18" fill="#1E293B" stroke="#64748B" stroke-width="4"/>
                            <circle cx="150" cy="115" r="8" fill="#94A3B8"/>
                            <circle cx="150" cy="115" r="3" fill="#FFFFFF"/>
                            <!-- Scooter Chassis (Vibrant Sky Blue) -->
                            <path d="M50 115L75 110L90 115L120 115L135 90L150 115" stroke="#0284C7" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M75 110L85 85L125 85L135 90" fill="#0284C7"/>
                            <path d="M125 85L140 60L130 55" stroke="#0369A1" stroke-width="5" stroke-linecap="round"/>
                            <!-- Seat -->
                            <rect x="70" y="80" width="35" height="8" rx="4" fill="#0F172A"/>
                            <!-- Delivery Box (Parcel on rack) -->
                            <rect x="42" y="60" width="32" height="26" rx="4" fill="#E11D48"/>
                            <rect x="44" y="62" width="28" height="22" rx="2" fill="#BE123C"/>
                            <path d="M58 60V86M42 73H74" stroke="#FFE4E6" stroke-width="1.8"/>
                            <!-- AusPost horn/logo mark on parcel -->
                            <circle cx="58" cy="73" r="5" fill="#FFFFFF"/>
                            <path d="M56 71C58 69.5 60 71 60 73C60 75 58 76 56 74" stroke="#BE123C" stroke-width="1.2" stroke-linecap="round"/>
                            <!-- Driver Body & Helmet -->
                            <!-- Leg -->
                            <path d="M92 85L105 105L120 105" stroke="#0369A1" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                            <!-- Torso -->
                            <path d="M95 85L110 65" stroke="#0284C7" stroke-width="10" stroke-linecap="round"/>
                            <!-- Arm to handle -->
                            <path d="M108 67L128 62" stroke="#0284C7" stroke-width="4" stroke-linecap="round"/>
                            <!-- Head/Helmet -->
                            <circle cx="118" cy="48" r="12" fill="#0284C7"/>
                            <path d="M118 42C124 42 129 46 129 52H118V42Z" fill="#38BDF8"/>
                            <path d="M124 50H132" stroke="#0F172A" stroke-width="2.5" stroke-linecap="round"/>
                        </svg>

                        <!-- 100% Safe Stamp Badge -->
                        <div class="absolute -top-2 -right-2 bg-gradient-to-br from-rose-500 to-rose-600 text-white rounded-full p-2.5 shadow-lg border-2 border-white flex flex-col items-center justify-center w-14 h-14 rotate-12">
                            <span class="text-[11px] font-black leading-none">100%</span>
                            <span class="text-[8px] font-black uppercase tracking-wider leading-none mt-0.5">SAFE</span>
                        </div>
                    </div>

                    <!-- CTA Button -->
                    <div class="w-full relative z-10 mt-3">
                        <a href="<?= esc_url($shop_url) ?>" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#0284c7] to-[#0c4161] hover:from-[#0369a1] hover:to-[#082a40] text-white font-extrabold uppercase tracking-wider text-xs sm:text-sm py-3 px-5 shadow-md hover:shadow-lg transition-all active:scale-[0.98]">
                            <span>ORDER NOW</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>

                    <!-- Website Domain Stamp -->
                    <div class="mt-3 pt-3 border-t border-sky-200/60 w-full flex items-center justify-center gap-1.5 text-xs font-bold text-slate-600 relative z-10">
                        <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                        </svg>
                        <span>waklertaustralia.com</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- "How Order Tracking Works" Section -->
        <section class="space-y-6 pt-2" aria-labelledby="how-tracking-works-heading">
            <div class="border-b border-slate-200 pb-3">
                <h2 id="how-tracking-works-heading" class="font-heading text-2xl sm:text-3xl font-black text-[#0c4161] tracking-tight">
                    How Order Tracking Works
                </h2>
            </div>

            <div class="space-y-4">
                <!-- Step 1 -->
                <div class="rounded-2xl border border-slate-200 bg-white border-t-[4px] border-t-amber-500 p-5 sm:p-6 shadow-xs hover:border-slate-300 transition-all">
                    <h3 class="font-heading text-base sm:text-lg font-black text-slate-900 mb-2">
                        1. Order Dispatched
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed m-0">
                        Once your order leaves our facility, we email you a dispatch confirmation containing your Australia Post tracking number.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="rounded-2xl border border-slate-200 bg-white border-t-[4px] border-t-amber-500 p-5 sm:p-6 shadow-xs hover:border-slate-300 transition-all">
                    <h3 class="font-heading text-base sm:text-lg font-black text-slate-900 mb-2">
                        2. Enter Your Number
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed m-0">
                        Paste the tracking number into the field above and select "Track My Order". We'll open your parcel's results on the Australia Post website.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="rounded-2xl border border-slate-200 bg-white border-t-[4px] border-t-amber-500 p-5 sm:p-6 shadow-xs hover:border-slate-300 transition-all">
                    <h3 class="font-heading text-base sm:text-lg font-black text-slate-900 mb-2">
                        3. Follow Your Parcel
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed m-0">
                        Australia Post updates scan events at each stage — accepted, in transit, onboard for delivery, and delivered.
                    </p>
                </div>
            </div>
        </section>

        <!-- "Need Help?" Card -->
        <section class="rounded-2xl border-2 border-dashed border-sky-300/80 bg-gradient-to-r from-sky-50/60 via-white to-sky-50/40 p-6 sm:p-7 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5" aria-labelledby="need-help-heading">
            <div class="space-y-1.5 max-w-xl">
                <h3 id="need-help-heading" class="font-heading text-lg sm:text-xl font-extrabold text-[#0c4161]">
                    Need Help?
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed m-0">
                    Can't find your tracking number or no scans after 3 business days? <a href="<?= esc_url($contact_url) ?>" class="font-bold text-[#0c4161] underline hover:text-amber-600 transition-colors">Contact our support team</a> and we'll look into it.
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a href="<?= esc_url($contact_url) ?>" class="inline-flex items-center gap-2 rounded-xl bg-[#0c4161] hover:bg-[#082a40] text-white px-5 py-2.5 text-xs sm:text-sm font-extrabold uppercase tracking-wider shadow-sm transition-all">
                    <span>Contact Support</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </a>
            </div>
        </section>

        <!-- 3-Column Value Proposition / Trust Features -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-5 lg:gap-6 pt-2 pb-6" aria-label="Key Benefits">
            <!-- Free Shipping -->
            <div class="rounded-2xl border-2 border-dashed border-sky-200/90 bg-white p-6 shadow-xs hover:border-sky-400 hover:shadow-md transition-all flex flex-col items-center text-center">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white p-2 shadow-lg shadow-black/10 border-2 border-sky-100 mb-4 shrink-0">
                    <!-- AusPost Van SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-10 h-10 shrink-0" fill="none" aria-hidden="true">
                        <ellipse cx="32" cy="55" rx="20" ry="2.5" fill="#0C4161" fill-opacity="0.15" />
                        <rect x="6" y="20" width="34" height="24" rx="3" fill="#DC2626" />
                        <path d="M40 25H49.5C51.5 25 53.2 26.2 54 28L57.5 35.5C57.8 36.2 58 37 58 37.8V44H40V25Z" fill="#B91C1C" />
                        <path d="M42 27H49L53.5 35H42V27Z" fill="#FEE2E2" />
                        <rect x="10" y="27" width="26" height="5" rx="1.5" fill="#FFFFFF" fill-opacity="0.9" />
                        <circle cx="18" cy="46" r="6.5" fill="#1E293B" stroke="#F1F5F9" stroke-width="2" />
                        <circle cx="18" cy="46" r="2.5" fill="#FFFFFF" />
                        <circle cx="48" cy="46" r="6.5" fill="#1E293B" stroke="#F1F5F9" stroke-width="2" />
                        <circle cx="48" cy="46" r="2.5" fill="#FFFFFF" />
                        <circle cx="56" cy="40" r="1.5" fill="#FBBF24" />
                    </svg>
                </div>
                <h3 class="font-heading font-extrabold text-slate-900 text-base mb-2">Free Shipping</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed m-0">
                    On orders over $200 AUD — enjoy fast, secure, and discreet delivery right to your doorstep.
                </p>
            </div>

            <!-- 24/7 Support -->
            <div class="rounded-2xl border-2 border-dashed border-sky-200/90 bg-white p-6 shadow-xs hover:border-sky-400 hover:shadow-md transition-all flex flex-col items-center text-center">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white p-2 shadow-lg shadow-black/10 border-2 border-sky-100 mb-4 shrink-0">
                    <!-- 24/7 Support Shield SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-10 h-10 shrink-0" fill="none" aria-hidden="true">
                        <ellipse cx="32" cy="55" rx="18" ry="2.5" fill="#0C4161" fill-opacity="0.15" />
                        <path d="M32 7L16 13.5V27C16 40.5 23 48.5 32 52.5C41 48.5 48 40.5 48 27V13.5L32 7Z" fill="#0284C7" />
                        <path d="M32 10L18.5 15.5V27C18.5 38.5 24.5 45.8 32 49.2C39.5 45.8 45.5 38.5 45.5 27V15.5L32 10Z" fill="#38BDF8" />
                        <circle cx="32" cy="29" r="10" fill="#0C4161" />
                        <path d="M26 29H38M32 23V35" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round" />
                    </svg>
                </div>
                <h3 class="font-heading font-extrabold text-slate-900 text-base mb-2">24/7 Support</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed m-0">
                    We’re here to help anytime — day or night, our team is ready to assist you with your orders and inquiries.
                </p>
            </div>

            <!-- Secure Payment -->
            <div class="rounded-2xl border-2 border-dashed border-sky-200/90 bg-white p-6 shadow-xs hover:border-sky-400 hover:shadow-md transition-all flex flex-col items-center text-center">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white p-2 shadow-lg shadow-black/10 border-2 border-sky-100 mb-4 shrink-0">
                    <!-- Secure Lock Shield SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-10 h-10 shrink-0" fill="none" aria-hidden="true">
                        <ellipse cx="32" cy="55" rx="18" ry="2.5" fill="#0C4161" fill-opacity="0.15" />
                        <path d="M32 7L16 13.5V27C16 40.5 23 48.5 32 52.5C41 48.5 48 40.5 48 27V13.5L32 7Z" fill="#D97706" />
                        <path d="M32 10L18.5 15.5V27C18.5 38.5 24.5 45.8 32 49.2C39.5 45.8 45.5 38.5 45.5 27V15.5L32 10Z" fill="#F59E0B" />
                        <rect x="25" y="27" width="14" height="12" rx="2.5" fill="#FFFFFF" />
                        <path d="M28 27V23C28 20.8 29.8 19 32 19C34.2 19 36 20.8 36 23V27" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round" />
                        <circle cx="32" cy="33" r="1.5" fill="#B45309" />
                    </svg>
                </div>
                <h3 class="font-heading font-extrabold text-slate-900 text-base mb-2">Secure Payment</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed m-0">
                    Shop with confidence — all transactions are 100% safe, encrypted, and protected for your peace of mind.
                </p>
            </div>
        </section>

    </div>
</main>

<!-- Client-side Tracker Redirection Script -->
<script>
(function() {
    const form = document.getElementById('auspost-tracking-form');
    const input = document.getElementById('auspost-tracking-input');
    const errorMsg = document.getElementById('tracking-error-msg');

    if (!form || !input) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const rawVal = input.value || '';
        // Strip whitespace and dashes
        const cleanVal = rawVal.replace(/[\s\-]/g, '');

        if (!cleanVal) {
            if (errorMsg) {
                errorMsg.textContent = 'Please enter your Australia Post tracking number.';
                errorMsg.classList.remove('hidden');
            }
            input.focus();
            return;
        }

        if (errorMsg) {
            errorMsg.classList.add('hidden');
        }

        // Direct Australia Post tracking details URL
        const targetUrl = 'https://auspost.com.au/mypost/track/#/details/' + encodeURIComponent(cleanVal);
        window.open(targetUrl, '_blank', 'noopener,noreferrer');
    });

    input.addEventListener('input', function() {
        if (errorMsg && !errorMsg.classList.contains('hidden')) {
            errorMsg.classList.add('hidden');
        }
    });
})();
</script>

<!-- Schema.org Structured Data for Order Tracking -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Track Your Order | Waklert Australia",
  "description": "Track your Waklert Australia order in real time with official Australia Post tracking.",
  "url": "<?= esc_url(home_url('/track-order/')) ?>",
  "breadcrumb": {
    "@type": "BreadcrumbList",
    "itemListElement": [
      {
        "@type": "ListItem",
        "position": 1,
        "name": "Home",
        "item": "<?= esc_url(home_url('/')) ?>"
      },
      {
        "@type": "ListItem",
        "position": 2,
        "name": "Track Order",
        "item": "<?= esc_url(home_url('/track-order/')) ?>"
      }
    ]
  }
}
</script>

<?php
get_footer();
