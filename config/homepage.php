<?php

// Homepage content for a stretch-ceiling installer. Contacts and photos are placeholders:
// replace them before launch. Every price lives under `pricing` and feeds both the service
// cards and the calculator.

return [

    // "Plafondi" is the French "plafond" (ceiling) with a Georgian ending. Register it with the
    // logo as one combined mark: a word this close to "ceiling" is hard to protect on its own.
    'brand' => [
        'name' => 'Plafondi',
        'tagline' => 'გასაჭიმი ჭერები თბილისში',
    ],

    // What Google shows in its results and what Facebook, Messenger and Viber show for a shared
    // link. The title and description lead with the words people search for ("გასაჭიმი ჭერი",
    // "ფასი"); :price is replaced with the cheapest finish. The preview image is drawn with that
    // price too, so redraw public/images/og-image.jpg when it changes.
    'seo' => [
        'title' => 'გასაჭიმი ჭერები თბილისში: ფასები და მონტაჟი',
        'description' => 'გასაჭიმი ჭერის მონტაჟი თბილისში, მცხეთასა და რუსთავში. მქრქალი, სატინი და პრიალა ჭერი :price-დან მ²-ზე. დაითვალეთ ფასი ონლაინ და დაჯავშნეთ უფასო აზომვა.',
        'image' => ['path' => 'images/og-image.jpg', 'width' => 1200, 'height' => 630],
        'logo' => 'images/logo.png',
        // Matches contact.hours; used in the business details Google reads.
        'opening_hours' => ['opens' => '10:00', 'closes' => '19:00'],
    ],

    'nav' => [
        'items' => [
            ['label' => 'სერვისები', 'href' => '#services'],
            ['label' => 'ნამუშევრები', 'href' => '#projects'],
            ['label' => 'ფასის დათვლა', 'href' => '#calculator'],
            ['label' => 'არეალი', 'href' => '#area'],
            ['label' => 'კონტაქტი', 'href' => '#contact'],
        ],
        'cta' => 'აზომვის დაჯავშნა',
    ],

    'hero' => [
        // Part of the page's main heading, so it carries the words people search for.
        'eyebrow' => 'გასაჭიმი ჭერები · თბილისი',
        'title' => 'ახალი ჭერი ძველის დაშლის გარეშე',
        'description' => 'ფირს ვჭიმავთ არსებული ჭერის ქვეშ, ამიტომ ბზარები, ლაქები და გაყვანილობა აღარ ჩანს. ვმუშაობთ სუფთად და ზუსტად.',
        'price_label' => 'ფასი',
        'primary_cta' => 'ფასის დათვლა',
        'secondary_cta' => 'აზომვის დაჯავშნა',
        // Stretch-ceiling photos from Pexels (free licence, no attribution required).
        // Replace them with photos of your own work when you have them.
        'slides' => [
            [
                'image' => 'https://images.pexels.com/photos/7005453/pexels-photo-7005453.jpeg?auto=compress&cs=tinysrgb&w=1920',
                'alt' => 'მისაღები ოთახი გასაჭიმი ჭერით და სანათი ხაზებით',
                'caption' => 'სანათი ხაზები მისაღებში',
            ],
            [
                'image' => 'https://images.pexels.com/photos/7546319/pexels-photo-7546319.jpeg?auto=compress&cs=tinysrgb&w=1920',
                'alt' => 'პრიალა თეთრი გასაჭიმი ჭერი, რომელშიც ჭაღი ირეკლება',
                'caption' => 'პრიალა თეთრი ჭერი',
            ],
            [
                'image' => 'https://images.pexels.com/photos/7173662/pexels-photo-7173662.jpeg?auto=compress&cs=tinysrgb&w=1920',
                'alt' => 'მისაღები ოთახი წითელი პრიალა გასაჭიმი ჭერით',
                'caption' => 'ფერადი პრიალა ჭერი',
            ],
            [
                'image' => 'https://images.pexels.com/photos/7195891/pexels-photo-7195891.jpeg?auto=compress&cs=tinysrgb&w=1920',
                'alt' => 'საძინებელი გასაჭიმი ჭერით და კონტურული განათებით',
                'caption' => 'კონტურული განათება საძინებელში',
            ],
            [
                'image' => 'https://images.pexels.com/photos/6238607/pexels-photo-6238607.jpeg?auto=compress&cs=tinysrgb&w=1920',
                'alt' => 'დერეფანი გასაჭიმი ჭერით და სანათი ხაზებით',
                'caption' => 'სანათი ხაზები დერეფანში',
            ],
        ],
    ],

    // Photos of our own work, used by the service cards and the projects gallery. Each one lives in
    // public/images/projects as <key>.webp (up to 1200px wide) and, when wider than 600px, <key>-sm.webp.
    'photos' => [
        'concrete-room-1' => ['width' => 1200, 'height' => 1600, 'alt' => 'მქრქალი თეთრი ჭერი სანათი ხაზებით ბეტონის კედლებიან ოთახში'],
        'concrete-room-2' => ['width' => 1200, 'height' => 1600, 'alt' => 'იგივე ჭერი მეორე კუთხიდან: სანათი ხაზები კედლებთან ახლოს'],
        'hallway-light-lines' => ['width' => 1170, 'height' => 1560, 'alt' => 'დერეფნის ჭერი გრძელი სანათი ხაზებით, ტრეკული სანათებით და სპოტებით'],
        'living-room-tracks' => ['width' => 1170, 'height' => 1560, 'alt' => 'მისაღების მქრქალი ჭერი ჩაშენებული ტრეკული სანათებით და ჭაღით'],
        'white-room-shadow-gap' => ['width' => 800, 'height' => 999, 'alt' => 'თეთრი ოთახი, სადაც ჭერსა და კედლებს შორის ჩრდილოვანი ღრიჭო გადის'],
        'shadow-gap-wall' => ['width' => 413, 'height' => 743, 'alt' => 'ჩრდილოვანი ღრიჭო ჭერსა და კედელს შორის, ახლო ხედი'],
        'shadow-gap-corner' => ['width' => 512, 'height' => 327, 'alt' => 'ჩრდილოვანი პროფილი კედლის გარე კუთხეზე'],
        'l-shaped-light-line' => ['width' => 1170, 'height' => 878, 'alt' => 'მქრქალი ჭერი კუთხოვანი სანათი ხაზით კედლების გასწვრივ'],
        'light-lines-and-spots' => ['width' => 480, 'height' => 640, 'alt' => 'ჭერი გეომეტრიული სანათი ხაზებით, სპოტებით და კონტურული განათებით'],
    ],

    'projects' => [
        'eyebrow' => 'ნამუშევრები',
        'title' => 'ჩვენი შესრულებული პროექტები',
        'description' => 'ფოტოები ჩვენი ობიექტებიდან. დააჭირეთ პროექტს და ფოტოებს დიდ ზომაში ნახავთ.',
        'labels' => [
            'photos' => 'ფოტო',
            'open' => 'ფოტოების ნახვა',
            'viewer' => 'პროექტის ფოტოები',
            'close' => 'დახურვა',
            'previous' => 'წინა ფოტო',
            'next' => 'შემდეგი ფოტო',
        ],
        // `photos` are keys of the `photos` list above; the first one is the cover.
        'items' => [
            [
                'title' => 'სანათი ხაზები ბეტონის ინტერიერში',
                'tags' => ['მქრქალი ჭერი', 'სანათი ხაზები'],
                'photos' => ['concrete-room-1', 'concrete-room-2'],
            ],
            [
                'title' => 'გრძელი სანათი ხაზები დერეფანში',
                'tags' => ['სანათი ხაზები', 'ტრეკული სანათები', 'სპოტები'],
                'photos' => ['hallway-light-lines'],
            ],
            [
                'title' => 'მისაღები ჩაშენებული ტრეკებით',
                'tags' => ['მქრქალი ჭერი', 'ტრეკული სანათები'],
                'photos' => ['living-room-tracks'],
            ],
            [
                'title' => 'თეთრი ოთახი ჩრდილოვანი პროფილით',
                'tags' => ['მქრქალი ჭერი', 'ჩრდილოვანი პროფილი'],
                'photos' => ['white-room-shadow-gap', 'shadow-gap-wall', 'shadow-gap-corner'],
            ],
            [
                'title' => 'კუთხოვანი სანათი ხაზი',
                'tags' => ['მქრქალი ჭერი', 'სანათი ხაზი'],
                'photos' => ['l-shaped-light-line'],
            ],
            [
                'title' => 'სანათი ხაზები და სპოტები',
                'tags' => ['სანათი ხაზები', 'სპოტები', 'კონტურული განათება'],
                'photos' => ['light-lines-and-spots'],
            ],
        ],
    ],

    'services' => [
        'eyebrow' => 'სერვისები',
        'title' => 'ყველაფერი გასაჭიმი ჭერისთვის',
        'subtitle' => 'თითოეული სამუშაოს ფასი წინასწარ იცით, ჭერის მონტაჟიდან განათებამდე. საბოლოო თანხას აზომვის შემდეგ ერთად დავაზუსტებთ.',
        'cta' => 'დათვლა',
        // `photo` is a key of `photos`; `prices` are paths inside `pricing`; `preset` is applied to the
        // calculator when the card's button is clicked.
        'items' => [
            [
                'name' => 'ჭერი ნებისმიერ ოთახში',
                'description' => 'მისაღები, საძინებელი, აბაზანა თუ სამზარეულო. ორთქლი და ტენი ფირს არ აზიანებს, ფასი კი მოიცავს ფირს, პროფილს და მონტაჟს. კაფელზე ან კერამო-გრანიტზე დამაგრება ცალკე ითვლება, კედლის სიგრძით. პატარა ოთახებზე მოქმედებს მინიმალური ღირებულება.',
                'photo' => 'concrete-room-2',
                'prices' => ['finishes.matte', 'finishes.satin', 'finishes.gloss', 'minimum', 'walls.tile', 'walls.porcelain'],
                'preset' => [],
            ],
            [
                'name' => 'სანათები და კვანძები',
                'description' => 'სპოტებისა და ჭაღის ადგილებს, მილებსა და სავენტილაციო ხვრელებს მონტაჟისას ვამზადებთ.',
                'photo' => 'hallway-light-lines',
                'prices' => ['extras.lights', 'extras.pipes', 'extras.corners'],
                'preset' => ['lights' => 4],
            ],
            [
                'name' => 'პროფილები და ნიშები',
                'description' => 'ჩრდილოვანი ღრიჭო კედელთან და ფარული ნიშა ფარდისთვის ოთახს უფრო სუფთა, თანამედროვე იერს აძლევს.',
                'photo' => 'white-room-shadow-gap',
                'prices' => ['perimeter.shadow', 'extras.curtain'],
                'preset' => ['shadow' => true, 'curtain' => 3],
            ],
        ],
    ],

    // Single source of truth for prices (GEL).
    'pricing' => [
        'currency' => '₾',
        'from' => '-დან',

        // Small rooms are charged at least this much for the ceiling itself.
        'minimum' => ['name' => 'ერთი ჭერის მინიმუმი', 'price' => 180],

        // Ceiling film + profile + installation, per square meter.
        'finishes' => [
            'matte' => ['name' => 'მქრქალი', 'price' => 21, 'unit' => 'მ²'],
            'satin' => ['name' => 'სატინი', 'price' => 23, 'unit' => 'მ²'],
            'gloss' => ['name' => 'პრიალა', 'price' => 25, 'unit' => 'მ²'],
        ],

        // The profile is fixed to the walls, and drilling into tile or porcelain takes longer, so
        // those walls add a charge per meter of the room's perimeter. `label` is the calculator
        // option, `name` the line on the estimate.
        'walls' => [
            'plaster' => ['label' => 'ბათქაში / ბეტონი', 'name' => 'ჩვეულებრივი კედელი', 'price' => 0, 'unit' => 'მ'],
            'tile' => ['label' => 'კაფელი', 'name' => 'დამაგრება კაფელზე', 'price' => 3, 'unit' => 'მ'],
            'porcelain' => ['label' => 'კერამო-გრანიტი', 'name' => 'დამაგრება კერამო-გრანიტზე', 'price' => 6, 'unit' => 'მ'],
        ],

        // Counted add-ons. `step` defaults to 1.
        'extras' => [
            'lights' => ['name' => 'სანათის წერტილი', 'hint' => 'სპოტი ან ჭაღის ადგილი', 'price' => 12, 'unit' => 'ცალი'],
            'pipes' => ['name' => 'მილი ან ვენტილაცია', 'hint' => 'გამჭოლი ხვრელი ფირში', 'price' => 10, 'unit' => 'ცალი'],
            'corners' => ['name' => 'დამატებითი კუთხე', 'hint' => 'თუ ოთახი მართკუთხა არ არის', 'price' => 4, 'unit' => 'ცალი'],
            'curtain' => ['name' => 'ფარდის ნიშა', 'hint' => 'ნიშის სიგრძე მეტრებში', 'price' => 110, 'unit' => 'მ', 'step' => 0.5],
        ],

        // Options priced along the whole room perimeter when switched on.
        'perimeter' => [
            'shadow' => ['name' => 'ჩრდილოვანი პროფილი', 'hint' => 'ღრიჭო კედელთან, მთელ პერიმეტრზე', 'price' => 22, 'unit' => 'მ'],
        ],
    ],

    'calculator' => [
        'eyebrow' => 'გასაჭიმი ჭერის ფასი',
        'title' => 'ჩაწერეთ ოთახის ზომები და ნახეთ ფასი',
        'description' => 'ფასი ითვლება სიგრძითა და სიგანით. რამდენიმე ოთახისთვის დაამატეთ თითოეული და ჯამს ერთად ნახავთ.',
        // Sliders cover min..max meters; larger sizes can still be typed, up to input_max.
        'dimensions' => ['min' => 1, 'max' => 12, 'input_max' => 30, 'step' => 0.1, 'length' => 4.5, 'width' => 4],
        'max_rooms' => 8,
        'labels' => [
            'room' => 'ოთახი',
            'add_room' => 'ოთახის დამატება',
            'add_room_short' => 'ოთახი',
            'remove_room' => 'ოთახის წაშლა',
            'plan' => 'ოთახის გეგმა',
            'length' => 'სიგრძე',
            'width' => 'სიგანე',
            'meter' => 'მ',
            'sqm' => 'მ²',
            'area' => 'ფართი',
            'perimeter' => 'პერიმეტრი',
            'finish' => 'ფაქტურა',
            'walls' => 'კედლები',
            'walls_hint' => 'პროფილი კედელზე მაგრდება, ამიტომ ფასი კედლის მასალაზეც არის დამოკიდებული.',
            'wall_included' => 'ფასში შედის',
            'extras' => 'დამატებით',
            'ceiling' => 'ფირი და მონტაჟი',
            'minimum' => 'მინიმალური ღირებულება',
            'summary' => 'შეფასება',
            'total' => 'სულ',
        ],
        'cta' => 'აზომვის დაჯავშნა',
        'note' => 'თანხა საორიენტაციოა. საბოლოო ფასს აზომვისას შევათანხმებთ.',

        // The downloadable PDF estimate (see EstimatePdfController).
        'pdf' => [
            'button' => 'PDF-ის ჩამოტვირთვა',
            'title' => 'ჭერის შეფასება',
            'reference' => '№',
            'date' => 'თარიღი',
            'rooms' => 'ოთახები',
            'total_area' => 'ფართი ჯამში',
            'total' => 'სავარაუდო ჯამი',
            'columns' => ['item' => 'სამუშაო', 'quantity' => 'რაოდენობა', 'price' => 'ფასი', 'amount' => 'თანხა'],
            'notes_title' => 'გაითვალისწინეთ',
            'notes' => [
                'თანხა საორიენტაციოა და ეფუძნება თქვენ მიერ შეყვანილ ზომებს.',
                'საბოლოო ფასს ხელოსანი აზომვისას დააზუსტებს. აზომვა უფასოა და არაფერს გავალდებულებს.',
                'ფასი მოიცავს ფირს, პროფილს და მონტაჟს.',
            ],
            'contact_title' => 'აზომვის დასაჯავშნად დაგვიკავშირდით',
            'filename' => 'plafondi-estimate',
        ],
    ],

    'area' => [
        'eyebrow' => 'არეალი',
        'title' => 'თბილისი, მცხეთა და რუსთავი',
        'description' => 'ამ ქალაქებსა და მათ შემოგარენში ასაზომად უფასოდ მოვდივართ. სხვა რეგიონში ცხოვრობთ? მოგვწერეთ და მგზავრობის პირობებზე ცალკე შევთანხმდებით.',
        'aria_label' => 'მომსახურების არეალის რუკა',
        'radius_km' => 25,
        'cities' => [
            ['name' => 'თბილისი', 'lat' => 41.7151, 'lng' => 44.8271, 'main' => true],
            ['name' => 'მცხეთა', 'lat' => 41.8452, 'lng' => 44.7188],
            ['name' => 'რუსთავი', 'lat' => 41.5495, 'lng' => 44.9932],
        ],
    ],

    // Placeholder contact details: replace them with the real ones and set `placeholder` to false.
    // While it is true the page says the details are temporary and Google is not given them.
    'contact' => [
        'placeholder' => true,
        'eyebrow' => 'კონტაქტი',
        'title' => 'როდის გეწვიოთ?',
        'description' => 'დარეკეთ ან მოგვწერეთ და აირჩიეთ თქვენთვის მოსახერხებელი დღე. მოვალთ, ავზომავთ ოთახს და ზუსტ ფასს იქვე გეტყვით. აზომვა უფასოა და არაფერს გავალდებულებს.',
        'phone' => '+995 555 00 00 00',
        'email' => 'hello@example.com',
        'hours' => 'ყოველდღე, 10:00 - 19:00',
        'labels' => [
            'phone' => 'ტელეფონი',
            'email' => 'ელფოსტა',
            'hours' => 'სამუშაო საათები',
        ],
        'call' => 'დარეკვა',
        'write' => 'წერილის მოწერა',
        'demo_note' => 'საკონტაქტო მონაცემები დროებითია.',
    ],

    'footer' => [
        'rights' => 'ყველა უფლება დაცულია.',
    ],

];
