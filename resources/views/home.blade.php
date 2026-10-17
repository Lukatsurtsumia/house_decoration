<x-layouts.app :content="$content">
    <x-sections.navbar :content="$content" />

    <main>
        <x-sections.hero :content="$content" />
        <x-sections.transformation :content="$content" />
        <x-sections.services :content="$content" />
        <x-sections.projects :content="$content" />
        <x-sections.calculator :content="$content" />
        <x-sections.map :content="$content" />
        <x-sections.contact :content="$content" />
    </main>

    <x-sections.footer :content="$content" />
</x-layouts.app>
