@props(['content'])

{{-- "GE ▾" opens the list of languages; each one links to that language's home page. --}}
@php
    $locales = \App\Support\Content::locales();
    $current = app()->getLocale();
@endphp

<details data-lang-switcher {{ $attributes->merge(['class' => 'relative']) }}>
    <summary
        aria-label="{{ $content['ui']['language'] }}: {{ $locales[$current]['name'] }}"
        class="flex h-10 cursor-pointer list-none items-center gap-1.5 rounded-lg border border-line px-2.5 text-sm font-semibold text-ink transition-colors hover:bg-mist [&::-webkit-details-marker]:hidden"
    >
        <x-icon name="globe" class="size-4 text-ink-soft" />
        {{ $locales[$current]['label'] }}
    </summary>

    <div class="absolute right-0 mt-2 w-44 rounded-xl border border-line bg-white p-1.5 shadow-lg">
        @foreach ($locales as $code => $locale)
            <a
                href="{{ \App\Support\Content::url($code) }}"
                hreflang="{{ $code }}"
                lang="{{ $code }}"
                data-lang-link
                @if ($code === $current) aria-current="true" @endif
                class="flex items-center justify-between gap-3 rounded-lg px-3 py-2 text-sm text-ink-soft transition-colors hover:bg-mist hover:text-ink aria-[current=true]:bg-jade-50 aria-[current=true]:font-semibold aria-[current=true]:text-jade-700"
            >
                {{ $locale['name'] }}
                <span class="text-xs text-muted">{{ $locale['label'] }}</span>
            </a>
        @endforeach
    </div>
</details>
