<x-layouts.app :content="$content">
    <x-sections.navbar :content="$content" />

    <main>
        <x-sections.hero :content="$content" />
        <x-sections.services :content="$content" />
        <x-sections.calculator :content="$content" />
        <x-sections.map :content="$content" />
    </main>

    <x-sections.footer :content="$content" />
</x-layouts.app>
