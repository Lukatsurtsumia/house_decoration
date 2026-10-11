@props(['content'])

@php
    $projects = $content['projects'];
    $photos = $content['photos'];
    $labels = $projects['labels'];

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
@endphp

<section id="projects" class="scroll-mt-16 bg-ink py-20 text-white sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div data-reveal class="grid grid-cols-1 gap-6 lg:grid-cols-12 lg:items-end">
            <div class="lg:col-span-7">
                <p class="inline-flex rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-jade-100">{{ $projects['eyebrow'] }}</p>
                <h2 class="mt-4 font-display text-3xl font-semibold sm:text-4xl">{{ $projects['title'] }}</h2>
            </div>
            <p class="text-lg leading-relaxed text-white/60 lg:col-span-5">{{ $projects['description'] }}</p>
        </div>

        {{-- Phones swipe through the projects; wider screens get a grid. --}}
        <div
            data-reveal
            data-gallery
            data-gallery-slides='@json($slides)'
            class="-mx-4 mt-12 flex snap-x snap-mandatory scroll-px-4 gap-4 overflow-x-auto px-4 pb-1 [scrollbar-width:none] sm:mx-0 sm:grid sm:grid-cols-2 sm:gap-6 sm:overflow-visible sm:px-0 lg:grid-cols-3 lg:gap-8 [&::-webkit-scrollbar]:hidden"
        >
            @foreach ($projects['items'] as $index => $project)
                @php $cover = $project['photos'][0]; @endphp

                <article class="group relative w-[80%] shrink-0 snap-start overflow-hidden rounded-2xl bg-white/5 ring-1 ring-white/10 transition hover:ring-white/25 has-[:focus-visible]:ring-2 has-[:focus-visible]:ring-jade sm:w-auto">
                    <div class="relative aspect-4/5 overflow-hidden bg-white/5">
                        <x-photo
                            :name="$cover"
                            :photo="$photos[$cover]"
                            sizes="(min-width: 1280px) 400px, (min-width: 1024px) 33vw, (min-width: 640px) 50vw, 80vw"
                            class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.03]"
                        />

                        @if (count($project['photos']) > 1)
                            <span class="absolute top-3 right-3 inline-flex items-center gap-1.5 rounded-md bg-ink/70 px-2 py-1 text-xs font-semibold backdrop-blur">
                                <x-icon name="photos" class="size-3.5" />
                                {{ count($project['photos']) }} {{ $labels['photos'] }}
                            </span>
                        @endif
                    </div>

                    <div class="p-5">
                        <h3 class="font-display text-lg font-semibold">{{ $project['title'] }}</h3>
                        <p class="mt-1.5 text-sm text-white/55">{{ implode(' · ', $project['tags']) }}</p>
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
