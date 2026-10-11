@props(['name', 'photo', 'sizes' => '100vw', 'loading' => 'lazy'])

{{-- One of our own photos from config('homepage.photos'), with a 600px version for small screens when there is one. --}}
@php
    $path = 'images/projects/'.$name;
    $hasSmall = $photo['width'] > 600;
@endphp

<img
    src="{{ asset($path.'.webp') }}"
    @if ($hasSmall)
        srcset="{{ asset($path.'-sm.webp') }} 600w, {{ asset($path.'.webp') }} {{ $photo['width'] }}w"
        sizes="{{ $sizes }}"
    @endif
    width="{{ $photo['width'] }}"
    height="{{ $photo['height'] }}"
    alt="{{ $photo['alt'] }}"
    loading="{{ $loading }}"
    decoding="async"
    {{ $attributes }}
>
