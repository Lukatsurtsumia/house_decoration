@props(['content'])

{{-- Search results, link previews and the business details Google reads (schema.org JSON-LD),
     in the page's language, with links to the same page in the other languages. --}}
@php
    $brand = $content['brand'];
    $seo = $content['seo'];
    $pricing = $content['pricing'];
    $contact = $content['contact'];
    $area = $content['area'];

    $locales = \App\Support\Content::locales();
    $locale = app()->getLocale();
    // The business is one entity whatever the language, so its id lives on the default home page.
    $home = \App\Support\Content::url(\App\Support\Content::defaultLocale());
    $page = \App\Support\Content::url($locale);
    $cheapest = collect($pricing['finishes'])->min('price');
    $title = $seo['title'].' | '.$brand['name'];
    $description = str_replace(':price', $cheapest.' '.$pricing['currency'], $seo['description']);
    // Icons and the preview image get a version from their content, so browsers, Cloudflare and
    // Facebook fetch a new file as soon as it changes instead of showing a cached old one.
    $versioned = fn (string $path) => asset($path).'?v='.substr(md5_file(public_path($path)), 0, 8);
    $image = $versioned($seo['image']['path']);
    $mainCity = collect($area['cities'])->firstWhere('main', true) ?? $area['cities'][0];

    $business = [
        '@type' => 'HomeAndConstructionBusiness',
        '@id' => $home.'#business',
        'name' => $brand['name'],
        'description' => $description,
        'url' => $home,
        'logo' => $versioned($seo['logo']),
        // Finished work only: the "before" photos show bare concrete.
        'image' => array_merge([$image], array_map(
            fn (string $name) => asset("images/projects/{$name}.webp"),
            array_values(array_filter(array_keys($content['photos']), fn (string $name) => ! str_ends_with($name, '-before'))),
        )),
        'priceRange' => $cheapest.'-'.collect($pricing['finishes'])->max('price').' '.$pricing['currency'].' / '.collect($pricing['finishes'])->first()['unit'],
        'currenciesAccepted' => 'GEL',
        'address' => ['@type' => 'PostalAddress', 'addressLocality' => $mainCity['name'], 'addressCountry' => 'GE'],
        'geo' => ['@type' => 'GeoCoordinates', 'latitude' => $mainCity['lat'], 'longitude' => $mainCity['lng']],
        'areaServed' => array_map(fn (array $city) => ['@type' => 'City', 'name' => $city['name']], $area['cities']),
        'openingHoursSpecification' => [[
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            'opens' => $seo['opening_hours']['opens'],
            'closes' => $seo['opening_hours']['closes'],
        ]],
        'hasOfferCatalog' => [
            '@type' => 'OfferCatalog',
            'name' => $seo['title'],
            'itemListElement' => array_values(array_map(fn (array $finish) => [
                '@type' => 'Offer',
                'itemOffered' => ['@type' => 'Service', 'name' => str_replace(':finish', $finish['name'], $seo['offer'])],
                'priceSpecification' => [
                    '@type' => 'UnitPriceSpecification',
                    'price' => $finish['price'],
                    'priceCurrency' => 'GEL',
                    'unitText' => $finish['unit'],
                ],
            ], $pricing['finishes'])),
        ],
    ];

    // Made-up contact details must never reach Google.
    if (! ($contact['placeholder'] ?? false)) {
        $business['telephone'] = preg_replace('/\s+/', '', $contact['phone']);
        $business['email'] = $contact['email'];
    }

    $schema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'WebSite',
                '@id' => $home.'#website',
                'url' => $home,
                'name' => $brand['name'],
                'alternateName' => parse_url($home, PHP_URL_HOST),
                'inLanguage' => array_keys($locales),
                'publisher' => ['@id' => $home.'#business'],
            ],
            $business,
            [
                '@type' => 'FAQPage',
                '@id' => $page.'#faq',
                'url' => $page,
                'inLanguage' => $locale,
                'mainEntity' => array_map(fn (array $item) => [
                    '@type' => 'Question',
                    'name' => $item['question'],
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['answer']],
                ], \App\Support\Faq::items($content)),
            ],
        ],
    ];
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $page }}">
@foreach ($locales as $code => $language)
    <link rel="alternate" hreflang="{{ $code }}" href="{{ \App\Support\Content::url($code) }}">
@endforeach
<link rel="alternate" hreflang="x-default" href="{{ $home }}">

<link rel="icon" href="{{ $versioned('favicon.ico') }}" sizes="48x48">
<link rel="icon" href="{{ $versioned('favicon.svg') }}" type="image/svg+xml">
<link rel="apple-touch-icon" href="{{ $versioned('apple-touch-icon.png') }}">

<meta property="og:type" content="website">
<meta property="og:locale" content="{{ $locales[$locale]['og'] }}">
@foreach ($locales as $code => $language)
    @continue($code === $locale)
    <meta property="og:locale:alternate" content="{{ $language['og'] }}">
@endforeach
<meta property="og:site_name" content="{{ $brand['name'] }}">
<meta property="og:url" content="{{ $page }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:image:width" content="{{ $seo['image']['width'] }}">
<meta property="og:image:height" content="{{ $seo['image']['height'] }}">
<meta property="og:image:alt" content="{{ $brand['name'] }}: {{ $brand['tagline'] }}">
<meta name="twitter:card" content="summary_large_image">

<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_PRETTY_PRINT) !!}</script>
