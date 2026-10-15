{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
@foreach ($pages as $page)
    <url>
        <loc>{{ $page }}</loc>
        <changefreq>monthly</changefreq>
        <priority>{{ $page === $default ? '1.0' : '0.8' }}</priority>
@foreach ($alternates as $alternate)
        <xhtml:link rel="alternate" hreflang="{{ $alternate['hreflang'] }}" href="{{ $alternate['href'] }}"/>
@endforeach
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ $default }}"/>
@if ($page === $default)
@foreach ($images as $image)
        <image:image>
            <image:loc>{{ $image }}</image:loc>
        </image:image>
@endforeach
@endif
    </url>
@endforeach
</urlset>
