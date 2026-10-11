@props(['content'])

@php
    $area = $content['area'];
    $mapConfig = collect($area)->only(['cities', 'radius_km'])->all();
@endphp

<section id="area" class="scroll-mt-16 bg-white py-20 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div data-reveal class="grid grid-cols-1 gap-6 lg:grid-cols-12 lg:items-end">
            <div class="lg:col-span-7">
                <p class="inline-flex rounded-full bg-jade-50 px-3 py-1 text-xs font-semibold text-jade-700">{{ $area['eyebrow'] }}</p>
                <h2 class="mt-4 font-display text-3xl font-semibold text-ink sm:text-4xl">{{ $area['title'] }}</h2>
            </div>
            <p class="text-lg leading-relaxed text-muted lg:col-span-5">{{ $area['description'] }}</p>
        </div>

        <div data-reveal class="relative isolate mt-10 h-[360px] overflow-hidden rounded-2xl border border-line sm:h-[440px]">
            <div
                id="map"
                data-map
                data-map-config='@json($mapConfig)'
                role="region"
                aria-label="{{ $area['aria_label'] }}"
                class="absolute inset-0"
            ></div>
        </div>
    </div>
</section>
