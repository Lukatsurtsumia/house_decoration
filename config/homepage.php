<?php

// Homepage content for a stretch-ceiling installer. Contacts and photos are placeholders:
// replace them before launch. Every price lives under `pricing` and feeds both the service
// cards and the calculator.

return [

    // "Plafond" is French for ceiling. Register it with the logo as one combined mark:
    // the word alone is descriptive and hard to protect.
    'brand' => [
        'name' => 'Plafond',
        'tagline' => 'გაჭიმული ჭერები თბილისში',
    ],

    'nav' => [
        'items' => [
            ['label' => 'სერვისები', 'href' => '#services'],
            ['label' => 'ფასის დათვლა', 'href' => '#calculator'],
            ['label' => 'არეალი', 'href' => '#area'],
            ['label' => 'კონტაქტი', 'href' => '#contact'],
        ],
        'cta' => 'აზომვის დაჯავშნა',
    ],

    'hero' => [
        'eyebrow' => 'გაჭიმული ჭერი · თბილისი',
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
                'alt' => 'მისაღები ოთახი გაჭიმული ჭერით და სანათი ხაზებით',
                'caption' => 'სანათი ხაზები მისაღებში',
            ],
            [
                'image' => 'https://images.pexels.com/photos/7546319/pexels-photo-7546319.jpeg?auto=compress&cs=tinysrgb&w=1920',
                'alt' => 'პრიალა თეთრი გაჭიმული ჭერი, რომელშიც ჭაღი ირეკლება',
                'caption' => 'პრიალა თეთრი ჭერი',
            ],
            [
                'image' => 'https://images.pexels.com/photos/7173662/pexels-photo-7173662.jpeg?auto=compress&cs=tinysrgb&w=1920',
                'alt' => 'მისაღები ოთახი წითელი პრიალა გაჭიმული ჭერით',
                'caption' => 'ფერადი პრიალა ჭერი',
            ],
            [
                'image' => 'https://images.pexels.com/photos/7195891/pexels-photo-7195891.jpeg?auto=compress&cs=tinysrgb&w=1920',
                'alt' => 'საძინებელი გაჭიმული ჭერით და კონტურული განათებით',
                'caption' => 'კონტურული განათება საძინებელში',
            ],
            [
                'image' => 'https://images.pexels.com/photos/6238607/pexels-photo-6238607.jpeg?auto=compress&cs=tinysrgb&w=1920',
                'alt' => 'დერეფანი გაჭიმული ჭერით და სანათი ხაზებით',
                'caption' => 'სანათი ხაზები დერეფანში',
            ],
        ],
    ],

    'services' => [
        'eyebrow' => 'სერვისები',
        'title' => 'ყველაფერი ახალი ჭერისთვის',
        'subtitle' => 'ფირი, სანათები და დეკორატიული პროფილები ერთი გუნდისგან. ფასებს არ ვმალავთ, თითოეული ქვემოთ წერია. ზუსტ თანხას აზომვის შემდეგ დავაფიქსირებთ.',
        'cta' => 'დათვლა',
        // `prices` are paths inside `pricing`; `preset` is applied to the calculator when the card's button is clicked.
        'items' => [
            [
                'name' => 'ჭერი ნებისმიერ ოთახში',
                'description' => 'მისაღები, საძინებელი, აბაზანა თუ სამზარეულო. ორთქლი და ტენი ფირს არ აზიანებს, ფასი კი მოიცავს ფირს, პროფილს და მონტაჟს. პატარა ოთახებზე მოქმედებს მინიმალური ღირებულება.',
                'image' => 'https://images.pexels.com/photos/6970048/pexels-photo-6970048.jpeg?auto=compress&cs=tinysrgb&w=1400',
                'prices' => ['finishes.matte', 'finishes.satin', 'finishes.gloss', 'minimum'],
                'preset' => [],
            ],
            [
                'name' => 'სანათები და კვანძები',
                'description' => 'სპოტებისა და ჭაღის ადგილებს, მილებსა და სავენტილაციო ხვრელებს მონტაჟისას ვამზადებთ.',
                'image' => 'https://images.pexels.com/photos/7545494/pexels-photo-7545494.jpeg?auto=compress&cs=tinysrgb&w=1000',
                'prices' => ['extras.lights', 'extras.pipes', 'extras.corners'],
                'preset' => ['lights' => 4],
            ],
            [
                'name' => 'პროფილები და ნიშები',
                'description' => 'ჩრდილოვანი ღრიჭო კედელთან და ფარული ნიშა ფარდისთვის ოთახს უფრო სუფთა, თანამედროვე იერს აძლევს.',
                'image' => 'https://images.pexels.com/photos/13235831/pexels-photo-13235831.jpeg?auto=compress&cs=tinysrgb&w=1000',
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
        'eyebrow' => 'კალკულატორი',
        'title' => 'ჩაწერეთ ოთახის ზომები და ნახეთ ფასი',
        'description' => 'ფასი ითვლება სიგრძითა და სიგანით. რამდენიმე ოთახისთვის დაამატეთ თითოეული და ჯამს ერთად ნახავთ.',
        // Sliders cover min..max meters; larger sizes can still be typed, up to input_max.
        'dimensions' => ['min' => 1, 'max' => 12, 'input_max' => 30, 'step' => 0.1, 'length' => 4.5, 'width' => 4],
        'max_rooms' => 8,
        'labels' => [
            'room' => 'ოთახი',
            'add_room' => 'ოთახის დამატება',
            'remove_room' => 'ოთახის წაშლა',
            'plan' => 'ოთახის გეგმა',
            'length' => 'სიგრძე',
            'width' => 'სიგანე',
            'meter' => 'მ',
            'sqm' => 'მ²',
            'area' => 'ფართი',
            'perimeter' => 'პერიმეტრი',
            'finish' => 'ფაქტურა',
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
            'filename' => 'plafond-estimate',
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

    // Placeholder contact details: replace with the real ones before launch.
    'contact' => [
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
