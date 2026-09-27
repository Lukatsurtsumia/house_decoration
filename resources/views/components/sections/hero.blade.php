@props(['content'])

@php
    $hero = $content['hero'];
    $pricing = $content['pricing'];
    $cheapestFinish = collect($pricing['finishes'])->sortBy('price')->first();

    // Image CDNs like Pexels resize via ?w=, so thumbnails request a small copy.
    $thumbnail = fn (string $url) => preg_replace('/([?&])w=\d+/', '${1}w=240', $url);
@endphp

<section id="home" class="relative isolate bg-ink">
    <div
        data-hero-slideshow
        tabindex="0"
        aria-roledescription="სლაიდშოუ"
        aria-label="გასაჭიმი ჭერის ფოტოები"
        style="--slide-duration: 6s"
        class="relative flex min-h-[calc(100svh-4rem)] flex-col overflow-hidden focus:outline-none lg:h-[calc(100svh-4rem)] lg:max-h-[920px] lg:min-h-[620px]"
    >
        @foreach ($hero['slides'] as $i => $slide)
            <figure
                data-slide
                data-caption="{{ $slide['caption'] }}"
                aria-hidden="{{ $i === 0 ? 'false' : 'true' }}"
                class="absolute inset-0 m-0 transition-opacity duration-1000 ease-out {{ $i === 0 ? 'is-active' : 'opacity-0' }}"
            >
                <img
                    src="{{ $slide['image'] }}"
                    alt="{{ $slide['alt'] }}"
                    loading="{{ $i === 0 ? 'eager' : 'lazy' }}"
                    @if ($i === 0) fetchpriority="high" @endif
                    decoding="async"
                    class="h-full w-full object-cover object-[50%_25%]"
                >
            </figure>
        @endforeach

        <div aria-hidden="true" class="absolute inset-0 bg-linear-to-t from-ink via-ink/40 to-ink/10"></div>
        <div aria-hidden="true" class="absolute inset-0 bg-linear-to-r from-ink/70 via-ink/20 to-transparent"></div>

        <div class="relative z-10 mx-auto flex w-full max-w-7xl flex-1 flex-col justify-end px-4 pt-16 pb-36 sm:px-6 lg:px-8 lg:pb-32">
            <div data-reveal class="max-w-2xl text-white">
                <p class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold ring-1 ring-white/25 backdrop-blur">
                    <span class="size-1.5 rounded-full bg-jade"></span>
                    {{ $hero['eyebrow'] }}
                </p>

                <h1 class="mt-5 font-display text-4xl leading-[1.15] font-semibold text-balance sm:text-5xl lg:text-6xl">
                    {{ $hero['title'] }}
                </h1>

                <p class="mt-5 max-w-xl text-base leading-relaxed text-white/80 sm:text-lg">
                    {{ $hero['description'] }}
                </p>

                <div class="mt-8 flex flex-col gap-6 sm:flex-row sm:items-center sm:gap-8">
                    <div class="border-l-2 border-jade pl-4">
                        <p class="text-xs font-semibold text-white/60">{{ $hero['price_label'] }}</p>
                        <x-price
                            :amount="$cheapestFinish['price']"
                            :unit="$cheapestFinish['unit']"
                            :currency="$pricing['currency']"
                            :from="$pricing['from']"
                            class="font-display text-3xl font-semibold whitespace-nowrap"
                            unit-class="font-sans text-base font-normal text-white/60"
                        />
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a
                            href="#calculator"
                            class="group inline-flex items-center justify-center gap-2 rounded-lg bg-jade px-6 py-3.5 font-semibold text-white transition-colors hover:bg-jade-700"
                        >
                            {{ $hero['primary_cta'] }}
                            <x-icon name="arrow-right" class="size-4 transition-transform group-hover:translate-x-0.5" />
                        </a>
                        <a
                            href="#contact"
                            class="inline-flex items-center justify-center rounded-lg bg-white/10 px-6 py-3.5 font-semibold text-white ring-1 ring-white/30 backdrop-blur transition-colors hover:bg-white/20"
                        >
                            {{ $hero['secondary_cta'] }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute inset-x-0 bottom-0 z-10 border-t border-white/15 bg-ink/40 backdrop-blur-sm">
            <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-4 sm:flex-row sm:items-center sm:gap-6 sm:px-6 lg:px-8">
                <p class="flex min-w-0 flex-1 items-center gap-3 text-sm text-white">
                    <span data-slide-counter class="font-display text-lg tabular-nums">01</span>
                    <span aria-hidden="true" class="h-px w-8 shrink-0 bg-white/40"></span>
                    <span data-slide-caption class="truncate font-medium">{{ $hero['slides'][0]['caption'] }}</span>
                </p>

                <div class="flex items-center gap-2 sm:gap-3">
                    @foreach ($hero['slides'] as $i => $slide)
                        <button
                            type="button"
                            data-slide-thumb
                            data-index="{{ $i }}"
                            aria-label="სურათი {{ $i + 1 }}: {{ $slide['caption'] }}"
                            aria-current="{{ $i === 0 ? 'true' : 'false' }}"
                            class="relative h-1 flex-1 overflow-hidden rounded-full bg-white/30 transition-opacity focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white sm:h-14 sm:w-20 sm:flex-none sm:rounded-md sm:bg-transparent {{ $i === 0 ? 'opacity-100' : 'opacity-55 hover:opacity-90' }}"
                        >
                            <img src="{{ $thumbnail($slide['image']) }}" alt="" loading="lazy" decoding="async" class="hidden h-full w-full object-cover sm:block">
                            <span class="thumb-progress absolute inset-y-0 left-0 bg-white sm:inset-y-auto sm:bottom-0 sm:h-1 sm:bg-jade"></span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
