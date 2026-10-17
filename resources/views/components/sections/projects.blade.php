@props(['content'])

@php
    $projects = $content['projects'];
    $transformation = $content['transformation'];
    $photos = $content['photos'];
    $labels = $projects['labels'];
    $compareLabels = $transformation['labels'];

    // Every photo of every project in one list, so the viewer can step through all of them.
    $slides = [];
    $starts = [];

    foreach ($projects['items'] as $index => $project) {
        $starts[$index] = count($slides);
        $count = count($project['photos']);

        foreach ($project['photos'] as $position => $key) {
            $slides[] = [
                'src' => asset('images/projects/'.$key.'.webp'),
                'width' => $photos[$key]['width'],
                'height' => $photos[$key]['height'],
                'alt' => $photos[$key]['alt'],
                'title' => $project['title'],
                // Non-breaking spaces keep "1 / 3" on one line.
                'meta' => implode(' · ', $project['tags']).($count > 1 ? ' · '.($position + 1)."\u{00A0}/\u{00A0}".$count : ''),
            ];
        }
    }

    // One tab per kind of proof; the first is open when the page loads.
    $tabs = [
        'compare' => 'arrows-horizontal',
        'gallery' => 'photos',
        'videos' => 'play',
    ];
@endphp

<section id="projects" class="scroll-mt-16 bg-mist py-20 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div data-reveal class="grid grid-cols-1 gap-6 lg:grid-cols-12 lg:items-end">
            <div class="lg:col-span-7">
                <p class="inline-flex rounded-full bg-white px-3 py-1 text-xs font-semibold text-jade-700 ring-1 ring-line">{{ $projects['eyebrow'] }}</p>
                <h2 id="projects-title" class="mt-4 font-display text-3xl font-semibold text-ink sm:text-4xl">{{ $projects['title'] }}</h2>
            </div>
            <p class="text-lg leading-relaxed text-muted lg:col-span-5">{{ $projects['description'] }}</p>
        </div>

        <div data-reveal data-tabs class="mt-10">
            {{-- A segmented switch; arrow keys move between the tabs. On phones it spans the width,
                 with each icon above its label. --}}
            <div role="tablist" aria-labelledby="projects-title" class="grid grid-cols-3 gap-1 rounded-2xl bg-white p-1 shadow-sm ring-1 ring-line sm:inline-flex sm:rounded-full">
                @foreach ($tabs as $key => $icon)
                    <button
                        type="button"
                        role="tab"
                        id="projects-tab-{{ $key }}"
                        aria-controls="projects-panel-{{ $key }}"
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                        tabindex="{{ $loop->first ? '0' : '-1' }}"
                        class="flex min-w-0 flex-col items-center justify-center gap-1 rounded-xl px-1 py-2.5 text-center text-xs leading-tight font-semibold text-balance [overflow-wrap:anywhere] text-ink-soft transition-colors hover:not-aria-selected:bg-mist hover:not-aria-selected:text-ink aria-selected:bg-ink aria-selected:text-white sm:flex-row sm:gap-2 sm:rounded-full sm:px-5 sm:text-sm"
                    >
                        <x-icon :name="$icon" class="size-4" />
                        {{ $projects['tabs'][$key] }}
                    </button>
                @endforeach
            </div>

            {{-- Before/after sliders: drag the line (or tap, or use the arrow keys) to show more of either photo.
                 "Before" is on the left of the line, "after" on the right; --pos is where the line sits.
                 When a photo scrolls into view the line sweeps across once, then settles in the middle. --}}
            <div id="projects-panel-compare" role="tabpanel" aria-labelledby="projects-tab-compare" class="mt-8">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:gap-10">
                    @foreach ($transformation['pairs'] as $pair)
                        <figure data-compare style="--pos: 50%" class="group/compare m-0">
                            <div
                                data-compare-frame
                                class="relative aspect-square cursor-ew-resize touch-pan-y overflow-hidden rounded-2xl bg-ink shadow-sm ring-1 ring-ink/5 select-none"
                            >
                                <x-photo
                                    :name="$pair['before']"
                                    :photo="$photos[$pair['before']]"
                                    sizes="(min-width: 768px) 50vw, 100vw"
                                    draggable="false"
                                    style="object-position: {{ $pair['position'] }}"
                                    class="pointer-events-none absolute inset-0 h-full w-full object-cover"
                                />

                                <div
                                    data-compare-after
                                    class="pointer-events-none absolute inset-0 [clip-path:inset(0_0_0_var(--pos))] group-data-[animating]/compare:transition-[clip-path] group-data-[animating]/compare:duration-900 group-data-[animating]/compare:ease-in-out"
                                >
                                    <x-photo
                                        :name="$pair['after']"
                                        :photo="$photos[$pair['after']]"
                                        sizes="(min-width: 768px) 50vw, 100vw"
                                        draggable="false"
                                        style="object-position: {{ $pair['position'] }}"
                                        class="h-full w-full object-cover"
                                    />
                                </div>

                                {{-- Each label fades when its photo is pushed off the frame. --}}
                                <span class="pointer-events-none absolute top-4 left-4 rounded-full bg-ink/75 px-3 py-1 text-xs font-semibold text-white backdrop-blur transition-opacity duration-300 group-data-[edge=start]/compare:opacity-0">
                                    {{ $compareLabels['before'] }}
                                </span>
                                <span class="pointer-events-none absolute top-4 right-4 rounded-full bg-jade px-3 py-1 text-xs font-semibold text-white transition-opacity duration-300 group-data-[edge=end]/compare:opacity-0">
                                    {{ $compareLabels['after'] }}
                                </span>

                                {{-- The line and its handle. --}}
                                <div
                                    aria-hidden="true"
                                    class="pointer-events-none absolute inset-y-0 left-(--pos) w-0.5 -translate-x-1/2 bg-white shadow-[0_0_18px_rgba(0,0,0,0.35)] group-data-[animating]/compare:transition-[left] group-data-[animating]/compare:duration-900 group-data-[animating]/compare:ease-in-out"
                                >
                                    <span class="absolute top-1/2 left-1/2 grid size-12 -translate-x-1/2 -translate-y-1/2 place-items-center rounded-full bg-white text-ink shadow-lg ring-1 ring-ink/10 transition-transform group-has-[:focus-visible]/compare:ring-4 group-has-[:focus-visible]/compare:ring-jade/50 group-data-[dragging]/compare:scale-110">
                                        <x-icon name="arrows-horizontal" class="size-5" />
                                    </span>
                                </div>

                                <span class="pointer-events-none absolute bottom-4 left-1/2 -translate-x-1/2 rounded-full bg-ink/70 px-3 py-1 text-xs font-semibold whitespace-nowrap text-white opacity-0 backdrop-blur transition-opacity duration-500 group-data-[hint]/compare:opacity-100">
                                    {{ $compareLabels['drag'] }}
                                </span>

                                {{-- The same position as a slider, for the keyboard and screen readers. --}}
                                <input
                                    type="range"
                                    data-compare-range
                                    data-label-before="{{ $compareLabels['before'] }}"
                                    data-label-after="{{ $compareLabels['after'] }}"
                                    min="0"
                                    max="100"
                                    step="5"
                                    value="50"
                                    aria-label="{{ $compareLabels['compare'] }}: {{ $pair['title'] }}"
                                    class="sr-only"
                                >
                            </div>

                            <figcaption class="mt-4 flex flex-wrap items-center justify-between gap-3">
                                <span class="font-display text-lg font-semibold text-ink">{{ $pair['title'] }}</span>
                                <span role="group" aria-label="{{ $compareLabels['compare'] }}" class="inline-flex rounded-lg border border-line bg-white p-1 text-sm font-semibold">
                                    <button type="button" data-compare-show="before" aria-pressed="false" class="rounded-md px-3 py-1.5 text-ink-soft transition-colors hover:text-ink aria-pressed:bg-ink aria-pressed:text-white">
                                        {{ $compareLabels['before'] }}
                                    </button>
                                    <button type="button" data-compare-show="after" aria-pressed="false" class="rounded-md px-3 py-1.5 text-ink-soft transition-colors hover:text-ink aria-pressed:bg-jade aria-pressed:text-white">
                                        {{ $compareLabels['after'] }}
                                    </button>
                                </span>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>

            {{-- Projects: phones swipe through them, wider screens get a grid; each card opens the viewer. --}}
            <div id="projects-panel-gallery" role="tabpanel" aria-labelledby="projects-tab-gallery" hidden class="mt-8">
                <div
                    data-gallery
                    data-gallery-slides='@json($slides)'
                    class="-mx-4 flex snap-x snap-mandatory scroll-px-4 gap-4 overflow-x-auto px-4 pb-1 [scrollbar-width:none] sm:mx-0 sm:grid sm:grid-cols-2 sm:gap-6 sm:overflow-visible sm:px-0 lg:grid-cols-3 lg:gap-8 [&::-webkit-scrollbar]:hidden"
                >
                    @foreach ($projects['items'] as $index => $project)
                        @php $cover = $project['photos'][0]; @endphp

                        <article class="group relative w-[80%] shrink-0 snap-start overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-line transition hover:shadow-md hover:ring-ink/15 has-[:focus-visible]:ring-2 has-[:focus-visible]:ring-jade sm:w-auto">
                            <div class="relative aspect-4/5 overflow-hidden bg-ink/5 sm:aspect-square">
                                <x-photo
                                    :name="$cover"
                                    :photo="$photos[$cover]"
                                    sizes="(min-width: 1280px) 400px, (min-width: 1024px) 33vw, (min-width: 640px) 50vw, 80vw"
                                    class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.03]"
                                />

                                @if (count($project['photos']) > 1)
                                    <span class="absolute top-3 right-3 inline-flex items-center gap-1.5 rounded-md bg-ink/70 px-2 py-1 text-xs font-semibold text-white backdrop-blur">
                                        <x-icon name="photos" class="size-3.5" />
                                        {{ count($project['photos']) }} {{ $labels['photos'] }}
                                    </span>
                                @endif
                            </div>

                            <div class="p-5">
                                <h3 class="font-display text-lg font-semibold text-ink">{{ $project['title'] }}</h3>
                                <p class="mt-1.5 text-sm text-muted">{{ implode(' · ', $project['tags']) }}</p>
                            </div>

                            {{-- The whole card opens the viewer. --}}
                            <button
                                type="button"
                                data-gallery-open="{{ $starts[$index] }}"
                                aria-label="{{ $labels['open'] }}: {{ $project['title'] }}"
                                class="absolute inset-0 cursor-zoom-in focus:outline-none"
                            ></button>
                        </article>
                    @endforeach
                </div>
            </div>

            {{-- How we work, next to short silent clips from the before/after job: they play while on
                 screen and the button pauses them. --}}
            <div id="projects-panel-videos" role="tabpanel" aria-labelledby="projects-tab-videos" hidden class="mt-8">
                <div class="grid grid-cols-1 gap-10 lg:grid-cols-12 lg:items-center lg:gap-12">
                    <div class="lg:col-span-5 xl:col-span-4">
                        <h3 class="font-display text-2xl font-semibold text-ink sm:text-3xl">{{ $transformation['process_title'] }}</h3>

                        <ol class="mt-6 space-y-5">
                            @foreach ($transformation['steps'] as $i => $step)
                                <li class="flex gap-4">
                                    <span class="grid size-9 shrink-0 place-items-center rounded-full bg-jade font-display text-sm font-semibold text-white">{{ $i + 1 }}</span>
                                    <div class="min-w-0 pt-1">
                                        <p class="font-semibold text-ink">{{ $step['title'] }}</p>
                                        <p class="mt-1 text-sm leading-relaxed text-muted">{{ $step['text'] }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <div class="grid grid-cols-2 gap-4 sm:gap-6 lg:col-span-7 xl:col-span-8">
                        @foreach ($transformation['videos'] as $video)
                            <figure class="m-0">
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
                                        data-label-play="{{ $compareLabels['play'] }}"
                                        data-label-pause="{{ $compareLabels['pause'] }}"
                                        aria-label="{{ $compareLabels['play'] }}"
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
        </div>

        {{-- One call to action for all three tabs. --}}
        <div data-reveal class="mt-12 flex flex-col gap-4 rounded-2xl bg-white p-5 ring-1 ring-line sm:flex-row sm:items-center sm:justify-between sm:p-6">
            <p class="font-display text-lg font-semibold text-ink sm:text-xl">{{ $projects['cta_text'] }}</p>
            <a
                href="#contact"
                class="group/cta inline-flex items-center justify-center gap-2 rounded-lg bg-jade px-5 py-3 font-semibold text-white transition-colors hover:bg-jade-700"
            >
                {{ $projects['cta'] }}
                <x-icon name="arrow-right" class="size-4 transition-transform group-hover/cta:translate-x-0.5" />
            </a>
        </div>
    </div>

    <dialog
        data-lightbox
        aria-label="{{ $labels['viewer'] }}"
        class="m-0 size-full max-h-none max-w-none overflow-hidden border-0 bg-ink p-0 text-white backdrop:bg-transparent"
    >
        <div class="flex h-full flex-col">
            <div class="flex items-center justify-between gap-4 px-4 py-3 sm:px-6">
                <p data-lightbox-counter class="text-sm text-white/60 tabular-nums"></p>
                <button
                    type="button"
                    data-lightbox-close
                    aria-label="{{ $labels['close'] }}"
                    class="grid size-11 place-items-center rounded-lg text-white/80 transition-colors hover:bg-white/10 hover:text-white"
                >
                    <x-icon name="close" class="size-6" />
                </button>
            </div>

            <div data-lightbox-stage class="relative flex min-h-0 flex-1 items-center justify-center px-4 sm:px-20">
                <img data-lightbox-image alt="" class="h-auto max-h-full w-auto max-w-full rounded-lg object-contain shadow-2xl transition-opacity duration-200">

                <button
                    type="button"
                    data-lightbox-step="-1"
                    aria-label="{{ $labels['previous'] }}"
                    class="absolute top-1/2 left-2 grid size-10 -translate-y-1/2 place-items-center rounded-full bg-ink/60 text-white ring-1 ring-white/15 backdrop-blur transition-colors hover:bg-white/20 sm:left-5 sm:size-12"
                >
                    <x-icon name="arrow-left" />
                </button>
                <button
                    type="button"
                    data-lightbox-step="1"
                    aria-label="{{ $labels['next'] }}"
                    class="absolute top-1/2 right-2 grid size-10 -translate-y-1/2 place-items-center rounded-full bg-ink/60 text-white ring-1 ring-white/15 backdrop-blur transition-colors hover:bg-white/20 sm:right-5 sm:size-12"
                >
                    <x-icon name="arrow-right" />
                </button>
            </div>

            <div class="px-4 pt-4 pb-6 text-center sm:pb-8">
                <p data-lightbox-title class="font-display text-lg font-semibold"></p>
                <p data-lightbox-meta class="mt-1 text-sm text-white/55"></p>
            </div>
        </div>
    </dialog>
</section>
