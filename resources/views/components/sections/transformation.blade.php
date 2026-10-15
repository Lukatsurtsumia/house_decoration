@props(['content'])

@php
    $section = $content['transformation'];
    $photos = $content['photos'];
    $labels = $section['labels'];
@endphp

<section id="results" class="scroll-mt-16 bg-mist py-20 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div data-reveal class="grid grid-cols-1 gap-6 lg:grid-cols-12 lg:items-end">
            <div class="lg:col-span-7">
                <p class="inline-flex rounded-full bg-white px-3 py-1 text-xs font-semibold text-jade-700 ring-1 ring-line">{{ $section['eyebrow'] }}</p>
                <h2 class="mt-4 font-display text-3xl font-semibold text-ink sm:text-4xl">{{ $section['title'] }}</h2>
            </div>
            <p class="text-lg leading-relaxed text-muted lg:col-span-5">{{ $section['description'] }}</p>
        </div>

        {{-- Each photo starts on the bare concrete and wipes to the finished ceiling when it scrolls into view.
             The two shots were not taken from the same spot, so the reveal is animated rather than a drag slider. --}}
        <div class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-2 lg:gap-10">
            @foreach ($section['pairs'] as $i => $pair)
                <figure data-reveal data-compare data-state="before" style="--reveal-delay: {{ $i * 120 }}ms" class="group/compare m-0">
                    <div class="relative aspect-square overflow-hidden rounded-2xl bg-ink shadow-sm ring-1 ring-ink/5">
                        <x-photo
                            :name="$pair['before']"
                            :photo="$photos[$pair['before']]"
                            sizes="(min-width: 768px) 50vw, 100vw"
                            style="object-position: {{ $pair['position'] }}"
                            class="absolute inset-0 h-full w-full object-cover"
                        />

                        <div data-compare-after class="absolute inset-0 [clip-path:inset(0_100%_0_0)] transition-[clip-path] duration-1000 ease-in-out group-data-[state=after]/compare:[clip-path:inset(0_0_0_0)] motion-reduce:transition-none">
                            <x-photo
                                :name="$pair['after']"
                                :photo="$photos[$pair['after']]"
                                sizes="(min-width: 768px) 50vw, 100vw"
                                style="object-position: {{ $pair['position'] }}"
                                class="h-full w-full object-cover"
                            />
                        </div>

                        {{-- The bright edge that travels with the wipe. --}}
                        <span
                            aria-hidden="true"
                            class="pointer-events-none absolute inset-y-0 left-0 w-1 -translate-x-1/2 bg-white opacity-0 shadow-[0_0_28px_6px_rgba(255,255,255,0.65)] transition-[left,opacity] duration-1000 ease-in-out group-data-[state=after]/compare:left-full group-data-[wiping]/compare:opacity-100 motion-reduce:transition-none"
                        ></span>

                        <span class="pointer-events-none absolute top-4 left-4 rounded-full bg-ink/75 px-3 py-1 text-xs font-semibold text-white backdrop-blur transition-opacity duration-500 group-data-[state=after]/compare:opacity-0">
                            {{ $labels['before'] }}
                        </span>
                        <span class="pointer-events-none absolute top-4 left-4 rounded-full bg-jade px-3 py-1 text-xs font-semibold text-white opacity-0 transition-opacity duration-500 group-data-[state=after]/compare:opacity-100">
                            {{ $labels['after'] }}
                        </span>

                        <button
                            type="button"
                            data-compare-toggle
                            aria-label="{{ $labels['compare'] }}: {{ $pair['title'] }}"
                            class="absolute inset-0 cursor-pointer focus:outline-none focus-visible:ring-4 focus-visible:ring-jade/60 focus-visible:ring-inset"
                        ></button>
                    </div>

                    <figcaption class="mt-4 flex flex-wrap items-center justify-between gap-3">
                        <span class="font-display text-lg font-semibold text-ink">{{ $pair['title'] }}</span>
                        <span role="group" aria-label="{{ $labels['compare'] }}" class="inline-flex rounded-lg border border-line bg-white p-1 text-sm font-semibold">
                            <button type="button" data-compare-show="before" aria-pressed="true" class="rounded-md px-3 py-1.5 text-ink-soft transition-colors hover:text-ink aria-pressed:bg-ink aria-pressed:text-white">
                                {{ $labels['before'] }}
                            </button>
                            <button type="button" data-compare-show="after" aria-pressed="false" class="rounded-md px-3 py-1.5 text-ink-soft transition-colors hover:text-ink aria-pressed:bg-jade aria-pressed:text-white">
                                {{ $labels['after'] }}
                            </button>
                        </span>
                    </figcaption>
                </figure>
            @endforeach
        </div>

        <div class="mt-16 grid grid-cols-1 gap-10 lg:mt-24 lg:grid-cols-12 lg:items-center lg:gap-12">
            <div data-reveal class="lg:col-span-5 xl:col-span-4">
                <h3 class="font-display text-2xl font-semibold text-ink sm:text-3xl">{{ $section['process_title'] }}</h3>

                <ol class="mt-6 space-y-5">
                    @foreach ($section['steps'] as $i => $step)
                        <li class="flex gap-4">
                            <span class="grid size-9 shrink-0 place-items-center rounded-full bg-jade font-display text-sm font-semibold text-white">{{ $i + 1 }}</span>
                            <div class="min-w-0 pt-1">
                                <p class="font-semibold text-ink">{{ $step['title'] }}</p>
                                <p class="mt-1 text-sm leading-relaxed text-muted">{{ $step['text'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>

                <div class="mt-8 rounded-2xl bg-white p-5 ring-1 ring-line sm:p-6">
                    <p class="font-display text-lg font-semibold text-ink">{{ $section['cta_text'] }}</p>
                    <a
                        href="#contact"
                        class="group/cta mt-4 inline-flex items-center justify-center gap-2 rounded-lg bg-jade px-5 py-3 font-semibold text-white transition-colors hover:bg-jade-700"
                    >
                        {{ $section['cta'] }}
                        <x-icon name="arrow-right" class="size-4 transition-transform group-hover/cta:translate-x-0.5" />
                    </a>
                </div>
            </div>

            {{-- Short silent clips from the same job: they play while on screen and the button pauses them. --}}
            <div class="grid grid-cols-2 gap-4 sm:gap-6 lg:col-span-7 xl:col-span-8">
                @foreach ($section['videos'] as $i => $video)
                    <figure data-reveal style="--reveal-delay: {{ $i * 120 }}ms" class="m-0">
                        <div class="relative aspect-4/5 overflow-hidden rounded-2xl bg-ink shadow-sm">
                            <video
                                data-autoplay-video
                                muted
                                loop
                                playsinline
                                preload="none"
                                poster="{{ asset('videos/'.$video['file'].'.webp') }}"
                                width="{{ $video['width'] }}"
                                height="{{ $video['height'] }}"
                                aria-label="{{ $video['title'] }}"
                                class="h-full w-full object-cover"
                            >
                                <source src="{{ asset('videos/'.$video['file'].'.mp4') }}" type="video/mp4">
                            </video>

                            <button
                                type="button"
                                data-video-toggle
                                data-label-play="{{ $labels['play'] }}"
                                data-label-pause="{{ $labels['pause'] }}"
                                aria-label="{{ $labels['play'] }}"
                                class="group/video absolute right-3 bottom-3 grid size-10 place-items-center rounded-full bg-ink/60 text-white ring-1 ring-white/20 backdrop-blur transition-colors hover:bg-ink/80"
                            >
                                <x-icon name="play" class="size-4 group-data-[playing=true]/video:hidden" />
                                <x-icon name="pause" class="hidden size-4 group-data-[playing=true]/video:block" />
                            </button>
                        </div>
                        {{-- Two narrow columns on small phones: long words may wrap inside them. --}}
                        <figcaption class="mt-3 min-w-0 [overflow-wrap:anywhere]">
                            <p class="font-semibold text-ink">{{ $video['title'] }}</p>
                            <p class="mt-0.5 text-sm text-muted">{{ $video['caption'] }}</p>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </div>
</section>
