@props(['content'])

<footer class="border-t border-line bg-white">
    <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 py-10 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
        <a href="#home" class="flex items-center gap-2.5">
            <x-logo-mark size="sm" />
            <span class="font-display text-lg font-semibold text-ink">{{ $content['brand']['name'] }}</span>
        </a>

        <nav class="flex flex-wrap gap-x-6 gap-y-2 text-sm text-muted" aria-label="ქვედა ნავიგაცია">
            @foreach ($content['nav']['items'] as $item)
                <a href="{{ $item['href'] }}" class="transition-colors hover:text-ink">{{ $item['label'] }}</a>
            @endforeach
        </nav>

        <p class="text-sm text-muted">&copy; {{ date('Y') }} {{ $content['brand']['name'] }}. {{ $content['footer']['rights'] }}</p>
    </div>
</footer>
