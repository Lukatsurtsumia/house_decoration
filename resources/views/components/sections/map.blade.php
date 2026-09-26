@props(['content'])

@php
    $area = $content['area'];
    $contact = $content['contact'];
    $phoneHref = 'tel:'.preg_replace('/\s+/', '', $contact['phone']);
    $mapConfig = collect($area)->only(['cities', 'radius_km'])->all();

    $details = [
        ['icon' => 'phone', 'label' => $contact['labels']['phone'], 'value' => $contact['phone'], 'href' => $phoneHref],
        ['icon' => 'mail', 'label' => $contact['labels']['email'], 'value' => $contact['email'], 'href' => 'mailto:'.$contact['email']],
        ['icon' => 'clock', 'label' => $contact['labels']['hours'], 'value' => $contact['hours'], 'href' => null],
    ];
@endphp

<section id="area" class="scroll-mt-16 bg-white py-20 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div data-reveal class="grid gap-6 lg:grid-cols-12 lg:items-end">
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

<section id="contact" class="scroll-mt-16 bg-jade-50 py-16 sm:py-20">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-12 lg:items-center lg:px-8">
        <div data-reveal class="lg:col-span-6">
            <p class="inline-flex rounded-full bg-white px-3 py-1 text-xs font-semibold text-jade-700">{{ $contact['eyebrow'] }}</p>
            <h2 class="mt-4 font-display text-3xl font-semibold text-ink sm:text-4xl">{{ $contact['title'] }}</h2>
            <p class="mt-4 max-w-xl text-lg leading-relaxed text-muted">{{ $contact['description'] }}</p>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ $phoneHref }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-jade px-6 py-3.5 font-semibold text-white transition-colors hover:bg-jade-700">
                    <x-icon name="phone" class="size-4" />
                    {{ $contact['call'] }}
                </a>
                <a href="mailto:{{ $contact['email'] }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-ink/15 bg-white px-6 py-3.5 font-semibold text-ink transition-colors hover:border-ink/40">
                    <x-icon name="mail" class="size-4" />
                    {{ $contact['write'] }}
                </a>
            </div>
        </div>

        <ul data-reveal style="--reveal-delay: 100ms" class="divide-y divide-jade-100 rounded-2xl bg-white px-6 lg:col-span-5 lg:col-start-8">
            @foreach ($details as $detail)
                <li class="flex items-center gap-4 py-5">
                    <span class="grid size-11 shrink-0 place-items-center rounded-full bg-jade-50 text-jade-700">
                        <x-icon :name="$detail['icon']" />
                    </span>
                    <div class="min-w-0">
                        <p class="text-xs text-muted">{{ $detail['label'] }}</p>
                        @if ($detail['href'])
                            <a href="{{ $detail['href'] }}" class="font-display text-lg font-semibold break-words text-ink transition-colors hover:text-jade-700">{{ $detail['value'] }}</a>
                        @else
                            <p class="font-display text-lg font-semibold text-ink">{{ $detail['value'] }}</p>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>

        <p class="text-xs text-muted lg:col-span-12">{{ $contact['demo_note'] }}</p>
    </div>
</section>
