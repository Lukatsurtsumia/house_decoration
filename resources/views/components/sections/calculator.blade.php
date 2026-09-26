@props(['content'])

@php
    $calculator = $content['calculator'];
    $pricing = $content['pricing'];
    $dimensions = $calculator['dimensions'];
    $labels = $calculator['labels'];

    $calculatorConfig = [
        'currency' => $pricing['currency'],
        'minimum' => $pricing['minimum']['price'],
        'finishes' => $pricing['finishes'],
        'extras' => $pricing['extras'],
        'perimeter' => $pricing['perimeter'],
        'dimensions' => $dimensions,
        'maxRooms' => $calculator['max_rooms'],
        'labels' => $labels,
    ];
@endphp

<section id="calculator" class="scroll-mt-16 bg-mist py-20 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div data-reveal class="grid gap-6 lg:grid-cols-12 lg:items-end">
            <div class="lg:col-span-7">
                <p class="inline-flex rounded-full bg-white px-3 py-1 text-xs font-semibold text-jade-700 ring-1 ring-line">{{ $calculator['eyebrow'] }}</p>
                <h2 class="mt-4 font-display text-3xl font-semibold text-ink sm:text-4xl">{{ $calculator['title'] }}</h2>
            </div>
            <p class="text-lg leading-relaxed text-muted lg:col-span-5">{{ $calculator['description'] }}</p>
        </div>

        <div
            data-calculator
            data-calculator-config='@json($calculatorConfig)'
            class="mt-12 rounded-2xl border border-line bg-white shadow-sm"
        >
            <div class="sticky top-16 z-20 flex flex-wrap items-center justify-between gap-3 rounded-t-2xl border-b border-line bg-white/95 px-4 py-3 backdrop-blur sm:px-6">
                <div data-calc-rooms class="flex flex-wrap items-center gap-2"></div>
                <p class="flex items-baseline gap-2">
                    <span class="text-sm text-muted">{{ $labels['total'] }}</span>
                    <span data-calc-head-total class="font-display text-2xl font-semibold text-ink tabular-nums"></span>
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12">
                <div class="border-b border-line p-4 sm:p-6 lg:col-span-5 lg:border-r lg:border-b-0">
                    <p class="text-sm font-semibold text-ink">{{ $labels['plan'] }}</p>
                    <div class="mt-3 overflow-hidden rounded-xl border border-line bg-mist">
                        <svg data-calc-plan viewBox="0 0 320 240" class="block h-auto w-full" role="img" aria-label="{{ $labels['plan'] }}"></svg>
                    </div>

                    <div class="mt-5 space-y-4">
                        @foreach (['length', 'width'] as $dimension)
                            <div>
                                <div class="flex items-center justify-between gap-3">
                                    <label for="calc-{{ $dimension }}" class="text-sm font-medium text-ink-soft">{{ $labels[$dimension] }}</label>
                                    <div class="flex items-center gap-1.5">
                                        <input
                                            id="calc-{{ $dimension }}"
                                            type="number"
                                            data-calc-dimension="{{ $dimension }}"
                                            min="{{ $dimensions['min'] }}"
                                            max="{{ $dimensions['input_max'] }}"
                                            step="{{ $dimensions['step'] }}"
                                            inputmode="decimal"
                                            class="no-spin w-16 rounded-md border border-line bg-white px-2 py-1 text-right font-semibold text-ink tabular-nums focus:border-jade focus:outline-none"
                                        >
                                        <span class="text-sm text-muted">{{ $labels['meter'] }}</span>
                                    </div>
                                </div>
                                <input
                                    type="range"
                                    data-calc-dimension-range="{{ $dimension }}"
                                    min="{{ $dimensions['min'] }}"
                                    max="{{ $dimensions['max'] }}"
                                    step="{{ $dimensions['step'] }}"
                                    aria-label="{{ $labels[$dimension] }}"
                                    class="calc-range mt-1"
                                >
                            </div>
                        @endforeach
                    </div>

                    <dl class="mt-5 grid grid-cols-2 gap-3">
                        <div class="rounded-lg bg-mist px-4 py-3">
                            <dt class="text-xs text-muted">{{ $labels['area'] }}</dt>
                            <dd data-calc-area class="font-display text-xl font-semibold text-ink tabular-nums"></dd>
                        </div>
                        <div class="rounded-lg bg-mist px-4 py-3">
                            <dt class="text-xs text-muted">{{ $labels['perimeter'] }}</dt>
                            <dd data-calc-perimeter-length class="font-display text-xl font-semibold text-ink tabular-nums"></dd>
                        </div>
                    </dl>
                </div>

                <div class="space-y-8 p-4 sm:p-6 lg:col-span-7">
                    <fieldset>
                        <legend class="text-sm font-semibold text-ink">{{ $labels['finish'] }}</legend>
                        <div class="mt-3 grid grid-cols-3 gap-2 sm:gap-3">
                            @foreach ($pricing['finishes'] as $key => $finish)
                                <label class="flex cursor-pointer flex-col items-start gap-3 rounded-xl border border-line p-3 transition hover:border-ink/30 has-checked:border-jade has-checked:bg-jade-50 has-[:focus-visible]:ring-2 has-[:focus-visible]:ring-jade sm:p-4">
                                    <input type="radio" name="calc-finish" value="{{ $key }}" data-calc-finish class="sr-only" @checked($loop->first)>
                                    <span class="swatch swatch-{{ $key }} size-8 rounded-md ring-1 ring-ink/10"></span>
                                    <span>
                                        <span class="block text-sm font-semibold text-ink">{{ $finish['name'] }}</span>
                                        <x-price :amount="$finish['price']" :unit="$finish['unit']" :currency="$pricing['currency']" class="text-xs text-muted" />
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend class="text-sm font-semibold text-ink">{{ $labels['extras'] }}</legend>
                        <div class="mt-3 grid gap-2 sm:grid-cols-2">
                            @foreach ($pricing['extras'] as $key => $extra)
                                <div data-calc-extra-row="{{ $key }}" class="flex items-center justify-between gap-3 rounded-xl border border-line px-4 py-3">
                                    <div class="min-w-0">
                                        <p id="calc-extra-{{ $key }}" class="text-sm font-semibold text-ink">{{ $extra['name'] }}</p>
                                        <p class="text-xs text-muted">
                                            <x-price :amount="$extra['price']" :unit="$extra['unit']" :currency="$pricing['currency']" />
                                        </p>
                                    </div>
                                    <div class="flex shrink-0 items-center rounded-lg border border-line">
                                        <button
                                            type="button"
                                            data-calc-step="-1"
                                            data-key="{{ $key }}"
                                            aria-label="შემცირება: {{ $extra['name'] }}"
                                            class="grid size-8 place-items-center text-ink-soft transition-colors hover:text-ink disabled:pointer-events-none disabled:opacity-30"
                                        >
                                            <x-icon name="minus" class="size-4" />
                                        </button>
                                        <input
                                            type="number"
                                            data-calc-extra="{{ $key }}"
                                            aria-labelledby="calc-extra-{{ $key }}"
                                            min="0"
                                            step="{{ $extra['step'] ?? 1 }}"
                                            inputmode="decimal"
                                            class="no-spin w-10 bg-transparent text-center text-sm font-semibold text-ink tabular-nums focus:outline-none"
                                        >
                                        <button
                                            type="button"
                                            data-calc-step="1"
                                            data-key="{{ $key }}"
                                            aria-label="გაზრდა: {{ $extra['name'] }}"
                                            class="grid size-8 place-items-center text-ink-soft transition-colors hover:text-ink"
                                        >
                                            <x-icon name="plus" class="size-4" />
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                            @foreach ($pricing['perimeter'] as $key => $option)
                                <label data-calc-extra-row="{{ $key }}" class="flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-line px-4 py-3 transition has-checked:border-jade has-checked:bg-jade-50 sm:col-span-2">
                                    <span class="min-w-0">
                                        <span class="block text-sm font-semibold text-ink">{{ $option['name'] }}</span>
                                        <span class="block text-xs text-muted">
                                            {{ $option['hint'] }} ·
                                            <x-price :amount="$option['price']" :unit="$option['unit']" :currency="$pricing['currency']" />
                                        </span>
                                    </span>
                                    <input type="checkbox" data-calc-perimeter="{{ $key }}" class="peer sr-only">
                                    <span
                                        aria-hidden="true"
                                        class="relative h-6 w-11 shrink-0 rounded-full bg-line transition-colors peer-checked:bg-jade peer-focus-visible:ring-2 peer-focus-visible:ring-jade peer-focus-visible:ring-offset-2 after:absolute after:top-0.5 after:left-0.5 after:size-5 after:rounded-full after:bg-white after:shadow after:transition-transform peer-checked:after:translate-x-5"
                                    ></span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>
                </div>
            </div>

            <div class="grid gap-8 rounded-b-2xl bg-ink px-4 py-6 text-white sm:px-6 sm:py-8 lg:grid-cols-12">
                <div class="lg:col-span-7">
                    <h3 class="font-display text-xl font-semibold">{{ $labels['summary'] }}</h3>
                    <div data-calc-lines class="mt-4 space-y-4"></div>
                </div>
                <div class="flex flex-col justify-end lg:col-span-5 lg:items-end lg:text-right">
                    <p class="text-sm text-white/60">{{ $labels['total'] }}</p>
                    <p data-calc-total class="font-display text-5xl font-semibold tabular-nums">&nbsp;</p>
                    <p data-calc-total-sr class="sr-only" aria-live="polite"></p>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row lg:justify-end">
                        <a
                            href="#contact"
                            class="inline-flex items-center justify-center rounded-lg bg-jade px-6 py-3.5 font-semibold text-white transition-colors hover:bg-jade-700"
                        >
                            {{ $calculator['cta'] }}
                        </a>

                        {{-- The server re-prices the rooms from config and sends back a PDF estimate. --}}
                        <form method="POST" action="{{ route('estimate.pdf') }}" data-calc-pdf-form>
                            @csrf
                            <input type="hidden" name="rooms" data-calc-pdf-rooms>
                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-lg px-6 py-3.5 font-semibold text-white ring-1 ring-white/30 transition-colors hover:bg-white/10"
                            >
                                <x-icon name="download" class="size-4" />
                                {{ $calculator['pdf']['button'] }}
                            </button>
                        </form>
                    </div>

                    <p class="mt-4 max-w-sm text-xs leading-relaxed text-white/55">{{ $calculator['note'] }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
