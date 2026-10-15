<?php

// English texts for the site (US spelling). The keys mirror config/homepage.php; anything not
// listed here (prices, photos, links, settings) comes from that file. Lists are matched by
// position, so keep items in the same order as there.

return [

    'brand' => [
        'tagline' => 'Stretch ceilings in Tbilisi',
    ],

    'ui' => [
        'main_nav' => 'Main navigation',
        'mobile_nav' => 'Mobile navigation',
        'footer_nav' => 'Footer navigation',
        'menu_toggle' => 'Open or close the menu',
        'language' => 'Language',
        'slideshow' => 'slideshow',
        'slideshow_label' => 'Stretch ceiling photos',
        'slide' => 'Photo',
    ],

    'seo' => [
        'title' => 'Stretch Ceilings in Tbilisi: Prices and Installation',
        'description' => 'Stretch ceiling installation in Tbilisi, Mtskheta and Rustavi. Matte, satin and gloss ceilings from :price per m². Calculate your price online and book a free measurement.',
        'offer' => ':finish stretch ceiling',
        'image' => ['path' => 'images/og-image-en.jpg'],
    ],

    'nav' => [
        'items' => [
            ['label' => 'Services'],
            ['label' => 'Our work'],
            ['label' => 'Price calculator'],
            ['label' => 'Service area'],
            ['label' => 'Contact'],
        ],
        'cta' => 'Book a measurement',
    ],

    'hero' => [
        'eyebrow' => 'Stretch ceilings · Tbilisi',
        'title' => 'A new ceiling without tearing out the old one',
        'description' => 'We stretch the ceiling film just below your existing ceiling, so cracks, stains and wiring are hidden from view. We work cleanly and precisely.',
        'price_label' => 'Price',
        'primary_cta' => 'Calculate the price',
        'secondary_cta' => 'Book a measurement',
        'slides' => [
            ['alt' => 'Living room with a stretch ceiling and light lines', 'caption' => 'Light lines in a living room'],
            ['alt' => 'Glossy white stretch ceiling reflecting a chandelier', 'caption' => 'Glossy white ceiling'],
            ['alt' => 'Living room with a red glossy stretch ceiling', 'caption' => 'Colored gloss ceiling'],
            ['alt' => 'Bedroom with a stretch ceiling and perimeter lighting', 'caption' => 'Perimeter lighting in a bedroom'],
            ['alt' => 'Hallway with a stretch ceiling and light lines', 'caption' => 'Light lines in a hallway'],
        ],
    ],

    'photos' => [
        'concrete-room-1' => ['alt' => 'Matte white ceiling with light lines in a room with concrete walls'],
        'concrete-room-2' => ['alt' => 'The same ceiling from another angle: light lines near the walls'],
        'hallway-light-lines' => ['alt' => 'Hallway ceiling with long light lines, track lights and spotlights'],
        'living-room-tracks' => ['alt' => 'Matte living room ceiling with built-in track lights and a chandelier'],
        'white-room-shadow-gap' => ['alt' => 'White room with a shadow gap between the ceiling and the walls'],
        'shadow-gap-wall' => ['alt' => 'Close-up of the shadow gap between the ceiling and a wall'],
        'shadow-gap-corner' => ['alt' => 'Shadow gap profile on an outside wall corner'],
        'l-shaped-light-line' => ['alt' => 'Matte ceiling with an L-shaped light line along the walls'],
        'light-lines-and-spots' => ['alt' => 'Ceiling with geometric light lines, spotlights and perimeter lighting'],
    ],

    'projects' => [
        'eyebrow' => 'Our work',
        'title' => 'Completed projects',
        'description' => 'Photos from our own jobs. Tap a project to see its photos full size.',
        'labels' => [
            'photos' => 'photos',
            'open' => 'View photos',
            'viewer' => 'Project photos',
            'close' => 'Close',
            'previous' => 'Previous photo',
            'next' => 'Next photo',
        ],
        'items' => [
            ['title' => 'Light lines in a concrete interior', 'tags' => ['Matte ceiling', 'Light lines']],
            ['title' => 'Long light lines in a hallway', 'tags' => ['Light lines', 'Track lights', 'Spotlights']],
            ['title' => 'Living room with built-in tracks', 'tags' => ['Matte ceiling', 'Track lights']],
            ['title' => 'White room with a shadow gap profile', 'tags' => ['Matte ceiling', 'Shadow gap profile']],
            ['title' => 'L-shaped light line', 'tags' => ['Matte ceiling', 'Light line']],
            ['title' => 'Light lines and spotlights', 'tags' => ['Light lines', 'Spotlights', 'Perimeter lighting']],
        ],
    ],

    'services' => [
        'eyebrow' => 'Services',
        'title' => 'Everything for your stretch ceiling',
        'subtitle' => 'You know the price of every job up front, from installing the ceiling to the lighting. We confirm the final total together after measuring.',
        'cta' => 'Calculate',
        'items' => [
            [
                'name' => 'A ceiling for any room',
                'description' => 'Living room, bedroom, bathroom or kitchen. Steam and moisture do not harm the film, and the price includes the film, profile and installation. Fixing into tiles or porcelain stoneware is charged separately, per meter of wall. A minimum charge applies to small rooms.',
            ],
            [
                'name' => 'Lights and fittings',
                'description' => 'We prepare the openings for spotlights, chandeliers, pipes and vents while installing the ceiling.',
            ],
            [
                'name' => 'Profiles and niches',
                'description' => 'A shadow gap along the walls and a concealed curtain niche give the room a cleaner, more modern look.',
            ],
        ],
    ],

    'pricing' => [
        'from_prefix' => 'from ',
        'from' => '',
        'minimum' => ['name' => 'Minimum per ceiling'],
        'finishes' => [
            'matte' => ['name' => 'Matte', 'unit' => 'm²'],
            'satin' => ['name' => 'Satin', 'unit' => 'm²'],
            'gloss' => ['name' => 'Gloss', 'unit' => 'm²'],
        ],
        'walls' => [
            'plaster' => ['label' => 'Plaster / concrete', 'name' => 'Standard wall', 'unit' => 'm'],
            'tile' => ['label' => 'Tiles', 'name' => 'Fixing into tiles', 'unit' => 'm'],
            'porcelain' => ['label' => 'Porcelain stoneware', 'name' => 'Fixing into porcelain stoneware', 'unit' => 'm'],
        ],
        'extras' => [
            'lights' => ['name' => 'Light point', 'hint' => 'Spotlight or chandelier', 'unit' => 'pc'],
            'pipes' => ['name' => 'Pipe or vent', 'hint' => 'An opening through the film', 'unit' => 'pc'],
            'corners' => ['name' => 'Extra corner', 'hint' => 'If the room is not rectangular', 'unit' => 'pc'],
            'curtain' => ['name' => 'Curtain niche', 'hint' => 'Niche length in meters', 'unit' => 'm'],
        ],
        'perimeter' => [
            'shadow' => ['name' => 'Shadow gap profile', 'hint' => 'A gap along the walls, all the way around the room', 'unit' => 'm'],
        ],
    ],

    'calculator' => [
        'eyebrow' => 'Stretch ceiling prices',
        'title' => 'Enter your room size and see the price',
        'description' => 'The price is based on length and width. For several rooms, add each one and see the total together.',
        'labels' => [
            'room' => 'Room',
            'add_room' => 'Add a room',
            'add_room_short' => 'Room',
            'remove_room' => 'Remove room',
            'plan' => 'Room plan',
            'length' => 'Length',
            'width' => 'Width',
            'meter' => 'm',
            'sqm' => 'm²',
            'area' => 'Area',
            'perimeter' => 'Perimeter',
            'finish' => 'Finish',
            'walls' => 'Walls',
            'walls_hint' => 'The profile is fixed to the walls, so the wall material affects the price too.',
            'wall_included' => 'Included',
            'extras' => 'Extras',
            'ceiling' => 'Film and installation',
            'minimum' => 'Minimum charge',
            'summary' => 'Estimate',
            'total' => 'Total',
            'decrease' => 'Decrease',
            'increase' => 'Increase',
        ],
        'cta' => 'Book a measurement',
        'note' => 'This is an approximate amount. We agree on the final price when we measure.',
        'pdf' => [
            'button' => 'Download PDF',
            'title' => 'Ceiling estimate',
            'reference' => 'No.',
            'date' => 'Date',
            'rooms' => 'Rooms',
            'total_area' => 'Total area',
            'total' => 'Estimated total',
            'columns' => ['item' => 'Work', 'quantity' => 'Qty', 'price' => 'Price', 'amount' => 'Amount'],
            'notes_title' => 'Please note',
            'notes' => [
                'The amount is approximate and based on the sizes you entered.',
                'Our installer confirms the final price when measuring. The measurement is free and without obligation.',
                'The price includes the film, profile and installation.',
            ],
            'contact_title' => 'To book a measurement, contact us',
        ],
    ],

    'area' => [
        'eyebrow' => 'Service area',
        'title' => 'Tbilisi, Mtskheta and Rustavi',
        'description' => 'We come to measure for free in these cities and their surroundings. Live in another region? Write to us and we will agree on travel terms separately.',
        'aria_label' => 'Map of our service area',
        'cities' => [
            ['name' => 'Tbilisi'],
            ['name' => 'Mtskheta'],
            ['name' => 'Rustavi'],
        ],
    ],

    'faq' => [
        'eyebrow' => 'Questions',
        'title' => 'Frequently asked questions about stretch ceilings',
        'description' => 'Short answers to the questions we hear most often. If yours is not here, get in touch.',
        'cta' => 'Ask a question',
        'items' => [
            [
                'question' => 'How much does a stretch ceiling cost?',
                'answer' => 'The price depends on the finish: a square meter of matte ceiling costs {finishes.matte} ₾, satin {finishes.satin} ₾ and gloss {finishes.gloss} ₾. The price includes the film, profile and installation. The minimum per ceiling is {minimum} ₾. To see the price for your room, enter its size in the calculator.',
            ],
            [
                'question' => 'What is included in the price, and what costs extra?',
                'answer' => 'The price per square meter includes the film, profile and installation. Charged separately: light points ({extras.lights} ₾ each), pipe or vent openings ({extras.pipes} ₾ each), extra corners ({extras.corners} ₾ each), a curtain niche ({extras.curtain} ₾ per meter) and a shadow gap profile ({perimeter.shadow} ₾ per meter). Fixing into tiles adds {walls.tile} ₾ per meter of wall, and into porcelain stoneware {walls.porcelain} ₾.',
            ],
            [
                'question' => 'What is the difference between matte, satin and gloss ceilings?',
                'answer' => 'A matte ceiling looks like a well-painted one and suits any interior. Satin has a soft, silky sheen. A gloss ceiling reflects light, so the room looks taller and more spacious.',
            ],
            [
                'question' => 'Can I have a stretch ceiling in a bathroom or kitchen?',
                'answer' => 'Yes. Steam and moisture do not harm the film, so it works well in bathrooms and kitchens. If the walls are finished with tiles or porcelain stoneware, fixing the profile is charged separately.',
            ],
            [
                'question' => 'Does the old ceiling need to be removed?',
                'answer' => 'No. We stretch the film just below your existing ceiling, so cracks, stains and wiring are hidden from view. There is no need to remove the old ceiling.',
            ],
            [
                'question' => 'How much lower will the ceiling be?',
                'answer' => 'Usually the ceiling drops by a few centimeters. The exact height depends on the built-in lights and the condition of the existing ceiling, so we will tell you when we measure.',
            ],
            [
                'question' => 'How long does installation take?',
                'answer' => 'It depends on the number of rooms and lights. We agree on the exact days when we measure, so the work is scheduled at a time that suits you.',
            ],
            [
                'question' => 'Is the measurement free, and where do you work?',
                'answer' => 'The measurement is free and without obligation. We work in Tbilisi, Mtskheta, Rustavi and the surrounding areas. For other regions, we agree on travel terms separately.',
            ],
        ],
    ],

    'contact' => [
        'eyebrow' => 'Contact',
        'title' => 'When should we visit?',
        'description' => 'Call or write to us and choose a day that suits you. We will come, measure the room and tell you the exact price on the spot. The measurement is free and without obligation.',
        'hours' => 'Every day, 10:00 - 19:00',
        'labels' => [
            'phone' => 'Phone',
            'email' => 'Email',
            'hours' => 'Working hours',
        ],
        'call' => 'Call us',
        'write' => 'Send an email',
        'demo_note' => 'These contact details are temporary.',
    ],

    'footer' => [
        'rights' => 'All rights reserved.',
    ],

    'llms' => [
        'prices' => 'Prices (GEL)',
        'area' => 'Service area',
        'contact' => 'Contact',
        'website' => 'Website',
        'faq' => 'Frequently asked questions',
    ],

];
