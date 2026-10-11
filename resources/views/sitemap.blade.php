{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    <url>
        <loc>{{ $home }}</loc>
        <changefreq>monthly</changefreq>
        <priority>1.0</priority>
@foreach ($images as $image)
        <image:image>
            <image:loc>{{ $image }}</image:loc>
        </image:image>
@endforeach
    </url>
</urlset>
