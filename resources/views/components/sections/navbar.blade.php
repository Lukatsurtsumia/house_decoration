@props(['content'])

<header data-navbar class="sticky top-0 z-50 border-b border-line bg-white/90 backdrop-blur transition-shadow duration-300">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-6 px-4 sm:px-6 lg:px-8">
        <a href="#home" class="flex shrink-0 items-center gap-2.5">
            <x-logo-mark />
            <span class="leading-tight">
                <span class="block font-display text-xl font-semibold text-ink">{{ $content['brand']['name'] }}</span>
                {{-- Says what we do, so the name is not read as a lamp shop ("პლაფონი" also means a ceiling lamp). --}}
                <span class="hidden text-[11px] text-muted sm:block">{{ $content['brand']['tagline'] }}</span>
            </span>
        </a>

        <nav class="hidden items-center gap-8 lg:flex" aria-label="მთავარი ნავიგაცია">
            @foreach ($content['nav']['items'] as $item)
                <a
                    href="{{ $item['href'] }}"
                    data-nav-link
                    class="relative py-1 text-sm font-medium text-ink-soft transition-colors after:absolute after:inset-x-0 after:-bottom-0.5 after:h-0.5 after:scale-x-0 after:rounded-full after:bg-jade after:transition-transform hover:text-ink aria-[current=true]:text-ink aria-[current=true]:after:scale-x-100"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-2">
            <a
                href="#contact"
                class="hidden rounded-lg bg-ink px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-ink-soft sm:inline-flex"
            >
                {{ $content['nav']['cta'] }}
            </a>

            <button
                type="button"
                data-nav-toggle
                aria-expanded="false"
                aria-controls="mobile-nav-menu"
                class="inline-flex size-10 items-center justify-center rounded-lg border border-line text-ink transition-colors hover:bg-mist lg:hidden"
            >
                <span class="sr-only">მენიუს გახსნა/დახურვა</span>
                <x-icon name="menu" data-nav-icon-open />
                <x-icon name="close" class="hidden size-5" data-nav-icon-close />
            </button>
        </div>
    </div>

    <div
        id="mobile-nav-menu"
        data-nav-menu
        hidden
        class="absolute inset-x-0 top-full -translate-y-2 border-b border-line bg-white opacity-0 shadow-lg transition-all duration-200 lg:hidden"
    >
        <nav class="flex flex-col px-4 py-3" aria-label="მობილური ნავიგაცია">
            @foreach ($content['nav']['items'] as $item)
                <a href="{{ $item['href'] }}" class="border-b border-line py-3.5 text-base font-medium text-ink last:border-0">
                    {{ $item['label'] }}
                </a>
            @endforeach
            <a href="#contact" class="mt-3 mb-1 rounded-lg bg-ink px-4 py-3 text-center text-sm font-semibold text-white">
                {{ $content['nav']['cta'] }}
            </a>
        </nav>
    </div>
</header>

<div
    data-nav-backdrop
    hidden
    class="fixed inset-0 z-40 bg-ink/30 opacity-0 transition-opacity duration-200 lg:hidden"
></div>
