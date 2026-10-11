@props(['content'])

@php
    $faq = $content['faq'];
    $items = \App\Support\Faq::items($content);
@endphp

<section id="faq" class="scroll-mt-16 bg-mist py-20 sm:py-24">
    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-10 px-4 sm:px-6 lg:grid-cols-12 lg:gap-12 lg:px-8">
        <div data-reveal class="lg:col-span-4">
            <p class="inline-flex rounded-full bg-white px-3 py-1 text-xs font-semibold text-jade-700 ring-1 ring-line">{{ $faq['eyebrow'] }}</p>
            <h2 class="mt-4 font-display text-3xl font-semibold text-ink sm:text-4xl">{{ $faq['title'] }}</h2>
            <p class="mt-4 text-lg leading-relaxed text-muted">{{ $faq['description'] }}</p>
            <a
                href="#contact"
                class="group/link mt-6 inline-flex items-center gap-2 rounded-lg border border-line bg-white px-4 py-2.5 text-sm font-semibold text-ink transition-colors hover:border-jade hover:text-jade-700"
            >
                {{ $faq['cta'] }}
                <x-icon name="arrow-right" class="size-4 transition-transform group-hover/link:translate-x-0.5" />
            </a>
        </div>

        {{-- Native <details>: answers stay in the page for search engines and work without JavaScript. --}}
        <div data-reveal class="divide-y divide-line rounded-2xl border border-line bg-white lg:col-span-8">
            @foreach ($items as $item)
                <details name="faq" class="group px-5 sm:px-6" @if ($loop->first) open @endif>
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 py-5 [&::-webkit-details-marker]:hidden">
                        <h3 class="font-semibold text-ink sm:text-lg">{{ $item['question'] }}</h3>
                        <span class="grid size-8 shrink-0 place-items-center rounded-full bg-mist text-ink-soft transition-transform group-open:rotate-45">
                            <x-icon name="plus" class="size-4" />
                        </span>
                    </summary>
                    <p class="max-w-3xl pb-6 leading-relaxed text-muted">{{ $item['answer'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>
