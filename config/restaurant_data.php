<?php
/**
 * Saffron Grill - Core Restaurant Data & Static Fallback Metadata
 * San Ramon, CA
 */

return [
    'name' => 'Saffron Grill',
    'tagline' => 'Authentic Indian Cuisine & Lunch Buffet',
    'slogan' => 'Royal Flavors, Timeless Tandoori Traditions & Everyday Feasts',
    'description' => 'Saffron Grill offers authentic North & South Indian cuisine in San Ramon, CA. Experience daily grand lunch buffets ($19.99 weekday / $21.99 weekend), signature clay oven tandoori sizzlers, aromatic curries, and full-service royal catering across the Tri-Valley.',
    
    // Contact & Location
    'contact' => [
        'phone_primary' => '(925) 846-3077',
        'phone_primary_tel' => '+19258463077',
        'phone_secondary' => '(925) 369-4696',
        'phone_secondary_tel' => '+19253694696',
        'email' => 'gosaffrongrill@gmail.com',
        'address_street' => '3191 Crow Canyon Pl, Ste D',
        'address_locality' => 'San Ramon',
        'address_region' => 'CA',
        'address_postal' => '94583',
        'address_country' => 'US',
        'full_address' => '3191 Crow Canyon Pl, Ste D, San Ramon, CA 94583',
        'geo' => [
            'latitude' => 37.7663,
            'longitude' => -121.9745,
        ],
        'google_maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3155.856983791999!2d-121.9745!3d37.7663!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808ff37803a6db63%3A0x6bfa33f381c6a2!2s3191%20Crow%20Canyon%20Pl%20Ste%20D%2C%20San%20Ramon%2C%20CA%2094583!5e0!3m2!1sen!2sus!4v1700000000000!5m2!1sen!2sus',
        'social' => [
            'facebook' => 'https://www.facebook.com/profile.php?id=61590010434038',
            'instagram' => 'https://www.instagram.com/saffrongrillrestaurant',
            'yelp' => 'https://www.yelp.com/biz/saffron-grill-san-ramon',
        ],
    ],

    // Operating Hours & Buffet Timings
    'hours' => [
        'lunch_weekday' => [
            'days' => 'Monday – Friday',
            'time' => '11:30 AM – 3:00 PM',
            'price' => '$19.99',
            'label' => 'Weekday Lunch Buffet & À la Carte',
        ],
        'lunch_weekend' => [
            'days' => 'Saturday & Sunday',
            'time' => '12:00 PM – 3:30 PM',
            'price' => '$21.99',
            'label' => 'Grand Weekend Feast Buffet',
        ],
        'dinner' => [
            'days' => 'Daily (7 Days a Week)',
            'time' => '5:00 PM – 10:00 PM',
            'price' => 'À la Carte Dining',
            'label' => 'Dinner Service',
        ],
    ],

    // Service Areas (for GEO SEO)
    'service_areas' => [
        'San Ramon', 'Danville', 'Dublin', 'Pleasanton', 'Blackhawk', 
        'Alamo', 'Livermore', 'Walnut Creek', 'Tri-Valley', 'East Bay'
    ],

    // Catering Packages
    'catering_packages' => [
        [
            'id' => 'silver',
            'name' => 'Silver Feast',
            'price_per_person' => '$22',
            'min_guests' => 25,
            'description' => 'Perfect for corporate luncheons and family gatherings.',
            'includes' => ['2 Appetizers (1 Veg, 1 Non-Veg)', '2 Main Curries', 'Basmati Rice & Naan', 'Fresh Salad & Raita', '1 Classic Dessert (Gulab Jamun)']
        ],
        [
            'id' => 'gold',
            'name' => 'Royal Gold Banquet',
            'price_per_person' => '$28',
            'min_guests' => 40,
            'popular' => true,
            'description' => 'Our most requested party menu featuring tandoori grills and aromatic biryani.',
            'includes' => ['3 Appetizers (Tandoori Chicken + Samosa + Paneer Tikka)', '3 Main Curries (Butter Chicken, Goat Curry, Dal Makhani)', 'Hyderabadi Dum Biryani', 'Assorted Tandoori Naan & Garlic Naan', 'Salad, Raita, Chutneys', '2 Desserts (Gulab Jamun & Rasmalai)']
        ],
        [
            'id' => 'platinum',
            'name' => 'Imperial Maharaja Extravaganza',
            'price_per_person' => '$36',
            'min_guests' => 50,
            'description' => 'Grand luxury catering with live live-tandoor station options for weddings and galas.',
            'includes' => ['4 Appetizers (Tandoori Prawns, Seekh Kebab, Paneer Tikka, Veg Spring Rolls)', '4 Gourmet Entrees (Lamb Rogan Josh, Chicken Tikka Masala, Malai Kofta, Saag Paneer)', 'Specialty Biryani (Chicken & Veg)', 'Assorted Breads & Artisanal Kulchas', 'Full Chutney & Salad Bar', '3 Gourmet Desserts (Kulfi, Rasmalai, Warm Gulab Jamun)', 'Chafing Dishes & Server Support Available']
        ]
    ]
];
