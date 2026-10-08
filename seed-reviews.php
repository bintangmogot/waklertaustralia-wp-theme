<?php
function waklert_seed_dummy_reviews() {
    if (get_option('waklert_dummy_reviews_seeded')) {
        return; // Already seeded
    }

    $products = get_posts([
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ]);

    $names = ['Liam', 'Noah', 'Oliver', 'William', 'Elijah', 'James', 'Benjamin', 'Lucas', 'Mason', 'Ethan', 'Alexander', 'Henry', 'Jacob', 'Michael', 'Daniel', 'Olivia', 'Emma', 'Ava', 'Charlotte', 'Sophia', 'Amelia', 'Isabella', 'Mia', 'Evelyn', 'Harper', 'Camila', 'Gianna', 'Abigail', 'Luna', 'Ella'];
    
    $locations = ['Sydney, NSW', 'Melbourne, VIC', 'Brisbane, QLD', 'Perth, WA', 'Adelaide, SA', 'Gold Coast, QLD', 'Newcastle, NSW', 'Canberra, ACT'];

    $review_templates = [
        "Absolutely lifesaver for my 12-hour night shifts. Smooth energy and no crash.",
        "Fast shipping! Ordered on Tuesday and got it by Thursday. Works exactly as described.",
        "Very clean focus. I don't feel jittery at all like I do with too much coffee.",
        "Quality product. Will definitely be ordering from you guys again.",
        "Customer service was great when I had a question about shipping. The product itself is top notch.",
        "Perfect for when I need to study all day. Highly recommend.",
        "The best generic I've tried so far. Very consistent results.",
        "I was skeptical but this is the real deal. Gives me the edge I need for long drives.",
        "No complaints here. Good price and effective.",
        "Exactly what I needed to get through my busy work week without burning out.",
        "Always gets here on time. The tracking updates are super helpful.",
        "Much cheaper than the alternatives but works just as well. Very satisfied."
    ];

    foreach ($products as $product) {
        $product_id = $product->ID;
        
        // Add 5 reviews
        for ($i = 0; $i < 5; $i++) {
            $name = $names[array_rand($names)];
            $location = $locations[array_rand($locations)];
            $content = $review_templates[array_rand($review_templates)];
            $rating = rand(4, 5); // 4 or 5 stars

            $review_id = wp_insert_post([
                'post_type' => 'review',
                'post_title' => $name . ' - ' . $product->post_title,
                'post_content' => $content,
                'post_status' => 'publish'
            ]);

            if ($review_id && function_exists('update_field')) {
                update_field('linked_product', $product_id, $review_id);
                update_field('name', $name, $review_id);
                update_field('reviewer_meta', $location . ' - Verified Buyer', $review_id);
                update_field('rating', $rating, $review_id);
                
                // Random date in the past 60 days
                $timestamp = time() - rand(0, 60 * 24 * 60 * 60);
                update_field('review_date', date('F j, Y', $timestamp), $review_id);
            }
        }
    }

    update_option('waklert_dummy_reviews_seeded', true);
}
add_action('init', 'waklert_seed_dummy_reviews');
