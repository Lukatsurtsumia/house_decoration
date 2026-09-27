@props(['content'])

@php
    $services = $content['services'];
    $pricing = $content['pricing'];
@endphp

<section id="services" class="scroll-mt-16 bg-white py-20 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div data-reveal class="grid grid-cols-1 gap-6 lg:grid-cols-12 lg:items-end">
            <div class="lg:col-span-7">
                <p class="inline-flex rounded-full bg-jade-50 px-3 py-1 text-xs font-semibold text-jade-700">{{ $services['eyebrow'] }}</p>
                <h2 class="mt-4 font-display text-3xl font-semibold text-ink sm:text-4xl">{{ $services['title'] }}</h2>
            </div>
            <p class="text-lg leading-relaxed text-muted lg:col-span-5">{{ $services['subtitle'] }}</p>
        </div>

        <div class="mt-12 grid grid-cols-1 gap-6 md:grid-cols-2 lg:gap-8">
            @foreach ($services['items'] as $i => $service)
                <article
                    data-reveal
                    style="--reveal-delay: {{ max(0, $i - 1) * 100 }}ms"
                    @class([
                        'group flex flex-col rounded-2xl border border-line bg-white transition duration-300 hover:border-jade/40 hover:shadow-xl hover:shadow-ink/5',
                        'md:col-span-2 md:flex-row' => $loop->first,
                    ])
                >
                    {{-- The first (main) service spans the full width with its photo beside the text. --}}
                    <div @class([
                        'relative m-2 aspect-16/10 overflow-hidden rounded-xl bg-mist',
                        'md:aspect-auto md:min-h-80 md:w-1/2 md:shrink-0' => $loop->first,
                    ])>
                        <img
                            src="{{ $service['image'] }}"
                            alt="{{ $service['name'] }}"
                            loading="lazy"
                            decoding="async"
                            @class([
                                'h-full w-full object-cover transition duration-700 group-hover:scale-[1.03]',
                                'md:absolute md:inset-0' => $loop->first,
                            ])
                        >
                        <span class="absolute top-3 left-3 rounded-md bg-white px-2 py-0.5 font-display text-sm font-semibold text-ink">
                            {{ sprintf('%02d', $i + 1) }}
                        </span>
                    </div>

                    <div @class([
                        'flex flex-1 flex-col px-6 pt-4 pb-6 sm:px-8 sm:pb-8',
                        'md:justify-center md:py-8 lg:px-12' => $loop->first,
                    ])>
                        <h3 class="font-display text-2xl font-semibold text-ink">{{ $service['name'] }}</h3>
                        <p class="mt-2 leading-relaxed text-muted">{{ $service['description'] }}</p>

                        <ul class="mt-6 space-y-3">
                            @foreach ($service['prices'] as $path)
                                @php $entry = data_get($pricing, $path); @endphp
                                <li class="flex items-baseline gap-3">
                                    <span class="min-w-0 text-ink-soft [overflow-wrap:anywhere]">{{ $entry['name'] }}</span>
                                    <span aria-hidden="true" class="min-w-6 flex-1 border-b border-dotted border-ink/25"></span>
                                    <x-price
                                        :amount="$entry['price']"
                                        :unit="$entry['unit'] ?? null"
                                        :prefix="str_starts_with($path, 'walls.') ? '+' : ''"
                                        :currency="$pricing['currency']"
                                        class="font-semibold whitespace-nowrap text-ink"
                                        unit-class="font-normal text-muted"
                                    />
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-auto pt-8">
                            <a
                                href="#calculator"
                                data-calc-preset='@json($service['preset'])'
                                class="group/link inline-flex items-center gap-2 rounded-lg border border-line px-4 py-2.5 text-sm font-semibold text-ink transition-colors hover:border-jade hover:text-jade-700"
                            >
                                {{ $services['cta'] }}
                                <x-icon name="arrow-right" class="size-4 transition-transform group-hover/link:translate-x-0.5" />
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
